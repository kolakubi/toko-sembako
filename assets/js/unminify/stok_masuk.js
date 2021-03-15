let isCetak = false,
    produk = [],
    transaksi = $("#transaksi").DataTable({
        responsive: true,
        lengthChange: false,
        searching: false,
        scrollX: true
    });

function reloadTable() {
    transaksi.ajax.reload()
}

// function nota(jumlah) {
//     let hasil = "",
//         char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
//         total = char.length;
//     for (var r = 0; r < jumlah; r++) hasil += char.charAt(Math.floor(Math.random() * total));
//     return hasil
// }

function getNama() {
    $.ajax({
        url: produkGetNamaUrl,
        type: "post",
        dataType: "json",
        data: {
            id: $("#barcode").val()
        },
        success: res => {
            $("#nama_produk").html(res.nama_produk);
            $("#sisa").html(`Sisa ${res.stok}`);
            checkEmpty()
        },
        error: err => {
            console.log(err)
        }
    })
}

function checkStok() {
    $.ajax({
        url: produkGetStokUrl,
        type: "post",
        dataType: "json",
        data: {
            id: $("#barcode").val()
        },
        success: res => {
            let barcode = $("#barcode").val(),
                nama_produk = res.nama_produk,
                jumlah = parseInt($("#jumlah").val()),
                stok = parseInt(res.stok),
                harga = $('#harga_per_item').val(),
                dataBarcode = $("#barcode").val(),
                total = parseInt($("#total").html());

            let a = transaksi.rows().indexes().filter((a, t) => dataBarcode === transaksi.row(a).data()[0]);
            if (a.length > 0) {
                let row = transaksi.row(a[0]),
                    data = row.data();
                
                data[3] = data[3] + jumlah;
                row.data(data).draw();
                indexProduk = produk.findIndex(a => a.id == barcode);
                produk[indexProduk].stok = stok - data[3];
                $("#total").html(total + harga * jumlah)
                // total2
                $("#total2").html("Rp "+(total + harga * jumlah).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
                // ===============
                console.log(produk);
                
            } else {
                produk.push({
                    id: barcode,
                    stok: stok + jumlah,
                    terjual: jumlah,
                    harga_per_item: harga
                });
                transaksi.row.add([
                    dataBarcode,
                    nama_produk,
                    harga,
                    jumlah,
                    `<button name="${barcode}" class="btn btn-sm btn-danger" onclick="remove('${barcode}')">Hapus</btn>`]).draw();
                $("#total").html(total + harga * jumlah);
                // total2
                $("#total2").html("Rp "+(total + harga * jumlah).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                // ====================
                $("#jumlah").val("");
                $("#harga_per_item").val("");
                $("#tambah").attr("disabled", "disabled");
                $("#bayar").removeAttr("disabled")
                console.log(produk);
            }
        }
    })
}

function bayarCetak() {
    isCetak = true
}

function bayar() {
    isCetak = false
}

function checkEmpty() {
    let barcode = $("#barcode").val(),
        jumlah = $("#jumlah").val();
    if (barcode !== "" && jumlah !== "" && parseInt(jumlah) >= 1) {
        $("#tambah").removeAttr("disabled")    
    } else {
        $("#tambah").attr("disabled", "disabled")
    }
}

function checkUang() {
    let jumlah_uang = parseInt($('[name="jumlah_uang"').val()),
        jumlah_uang_transfer = parseInt($('[name="jumlah_uang_transfer"').val()),
        total_bayar = parseInt($(".total_bayar").html());
    if ((jumlah_uang+jumlah_uang_transfer) >= total_bayar) {
        $("#add").removeAttr("disabled");
        $("#cetak").removeAttr("disabled");
        $(".total_bayar2").css('color', 'green')
    } else {
        $("#add").attr("disabled", "disabled");
        $("#cetak").attr("disabled", "disabled");
        $(".total_bayar2").css('color', 'red')
    }
}

function remove(nama) {
    let data = transaksi.row($("[name=" + nama + "]").closest("tr")).data(),
        stok = data[3],
        harga = data[2],
        total = parseInt($("#total").html());
        akhir = total - stok * harga
    $("#total").html(akhir);
    // total2
    $("#total2").html("Rp "+akhir.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    // =================
    transaksi.row($("[name=" + nama + "]").closest("tr")).remove().draw();
    $("#tambah").attr("disabled", "disabled");
    if (akhir < 1) {
        $("#bayar").attr("disabled", "disabled")
    }

    let produkRemove = produk.filter(e => e.id != nama);
    produk = produkRemove;
    console.log(produk);
}

function add() {
    $('#loading-overlay').css('display', 'flex');
    let data = transaksi.rows().data(),
        qty = [];
        produkId = [];
        harga_per_item = []
    $.each(data, (index, value) => {
        qty.push(value[3]);
        produkId.push(value[0]);
        harga_per_item.push(value[2]);
    });
    $.ajax({
        url: addUrl,
        type: "post",
        dataType: "json",
        data: {
            produk: JSON.stringify(produk),
            produkId: produkId,
            qty: qty,
            harga_per_item: harga_per_item,
            tanggal: $("#tanggal").val(),
            harga: $("#total").html(),
            jumlah_uang: $('[name="jumlah_uang"]').val(),
            jumlah_uang_transfer: $('[name="jumlah_uang_transfer"]').val(),
            diskon: $('[name="diskon"]').val(),
            supplier: $("#supplier").val(),
            nota: $("#no_nota").html(),
            keterangan: $('#keterangan').val(),
            // metode_pembayaran: $('#metode_pembayaran').val()
        },
        success: res => {
            $('#loading-overlay').css('display', 'none');
            if(res == 'sukses'){
                Swal.fire("Sukses", "Sukses Membayar", "success").
                then(() => window.location.reload())
            }
            console.log(res);
        },
        error: err => {
            $('#loading-overlay').css('display', 'none');
            console.log(err.responseText)
        }
    })
}

function kembalian() {
    let total = parseInt($("#total").html()),
        jumlah_uang = parseInt($('[name="jumlah_uang"').val()),
        jumlah_uang_transfer = parseInt($('[name="jumlah_uang_transfer"').val()),
        diskon = parseInt($('[name="diskon"]').val());
        jumlah_uang = jumlah_uang == null ? 0 : jumlah_uang;
        jumlah_uang_transfer = jumlah_uang_transfer == null ? 0 : jumlah_uang_transfer;
    // $(".kembalian").html((jumlah_uang + jumlah_uang_transfer) - total - diskon);
    $(".kembalian").html((jumlah_uang + jumlah_uang_transfer) - total);
    // console.log("Jumlah uang "+(jumlah_uang + jumlah_uang_transfer));
    // console.log("total " + total);
    // console.log("diskon" +diskon);
    checkUang();
}

$("#barcode").select2({
    // placeholder: "Barcode",
    placeholder: "Produk",
    ajax: {
        url: getBarcodeUrl,
        type: "post",
        dataType: "json",
        data: params => ({
            barcode: params.term
        }),
        processResults: res => ({
            results: res
        }),
        cache: true
    }
});

$("#supplier").select2({
    placeholder: "Supplier",
    ajax: {
        url: supplierSearchUrl,
        type: "post",
        dataType: "json",
        data: params => ({
            supplier: params.term
        }),
        processResults: res => ({
            results: res
        }),
        cache: true
    }
});

$("#tanggal").datetimepicker({
    format: "dd-mm-yyyy h:ii:ss"
});
$(".modal").on("hidden.bs.modal", () => {
    $("#form")[0].reset();
    $("#form").validate().resetForm()
});
$(".modal").on("show.bs.modal", () => {
    let now = moment().format("D-MM-Y H:mm:ss"),
        total = $("#total").html(),
        jumlah_uang = $('[name="jumlah_uang"').val();
    $("#tanggal").val(now), 
    $(".total_bayar").html(total), 
    // total_bayar2
    $(".total_bayar2").html("Rp "+total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")),
    // ===============
    $(".kembalian").html(Math.max(jumlah_uang - total, 0))
});
$("#form").validate({
    errorElement: "span",
    errorPlacement: (err, el) => {
        err.addClass("invalid-feedback"), el.closest(".form-group").append(err)
    },
    submitHandler: () => {
        add()
    }
});
// $("#nota").html(nota(15));