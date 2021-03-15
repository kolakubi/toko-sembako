let laporan_keuangan = $("#invoice").DataTable( {
    responsive:true,
    scrollX:true,
    ajax:readUrl,
    columnDefs:[{
        searcable: true,
        orderable: true,
        targets: 0
    }],
    'pageLength' : 60,
    // munculin export ke excel
    dom: 'Bfrtip',
    buttons: [
        'excelHtml5',
        'pdfHtml5',
        'print'
    ],
    order:[[1, "asc"]],
    columns:[ 
        {data: null},
        {data: "tanggal"},
        {data: "pelanggan"},
        {data: "total_bayar"},
        {data: 'status'},
        {data: 'action'}
    ]
}

);
function reloadTable() {
    laporan_keuangan.ajax.reload()
}

laporan_keuangan.on("order.dt search.dt", ()=> {
    laporan_keuangan.column(0, {
        search: "applied", order: "applied"
    }).nodes().each((el, err)=> {
        el.innerHTML=err+1
    })
});

function edit(id) {
    $.ajax({
        url: readEdit,
        type: "post",
        dataType: "json",
        data: {
            id: id
        },
        success: res => {
            $('[name="no_invoice"]').val(res.nota);
            $('[name="pelanggan"]').val(res.pelanggan);
            $('[name="total_tagihan"]').val(res.total);
            $('[name="keterangan"]').val(res.keterangan);
            $('[name="id_pelanggan"]').val(res.id_pelanggan);
            $('[name="barcode"]').val(res.barcode);
            $('[name="qty"]').val(res.qty);
            $('[name="harga_per_item"]').val(res.harga_per_item);
            $('[name="id_kasir"]').val(res.id_kasir);
            $(".modal").modal("show");
            $(".modal-title").html("Bayar Invoice");
            $('.modal button[type="submit"]').html("Bayar");
            url = "edit";
            console.log(res);
        },
        error: err => {
            console.log(err)
        }
    })
}

function editData() {
    $('#loading-overlay').css('display', 'flex');

    let data = $("#form").serialize();
    console.log(data);
    $.ajax({
        url: editUrl,
        type: "post",
        dataType: "json",
        data: $("#form").serialize(),
        success: (res) => {
            $('#loading-overlay').css('display', 'none');
            console.log(res);
            $(".modal").modal("hide");
            Swal.fire("Sukses", "Sukses Mengedit Data", "success");
            reloadTable()
        },
        error: err => {
            $('#loading-overlay').css('display', 'none');
            console.log(err)
        }
    })
}

// function checkUang() {
//     let jumlah_uang = $('[name="jumlah_uang"').val(),
//         total_bayar = parseInt($("#total_tagihan").val());
//     if (jumlah_uang !== "" && jumlah_uang >= total_bayar) {
//         $("#total_tagihan").css('color', 'green');
//         $("#add").removeAttr("disabled");
//     } else {
//         $("#total_tagihan").css('color', 'red');
//         $("#add").attr("disabled", "disabled");
//     }
// }

function checkUang() {
    let jumlah_uang = parseInt($('[name="jumlah_uang"').val()),
        jumlah_uang_transfer = parseInt($('[name="jumlah_uang_transfer"').val()),
        total_bayar = parseInt($("#total_tagihan").val());
    if ((jumlah_uang+jumlah_uang_transfer) >= total_bayar) {
        $("#total_tagihan").css('color', 'green');
        $("#add").removeAttr("disabled");
    } else {
        $("#total_tagihan").css('color', 'red');
        $("#add").attr("disabled", "disabled");
    }
}

// function kembalian() {
//     let total = $("#total_tagihan").val(),
//         jumlah_uang = $('[name="jumlah_uang"').val();
//         // diskon = $('[name="diskon"]').val();
//     $(".kembalian").html(jumlah_uang - total);
//     checkUang();
// }

function kembalian() {
    let total = parseInt($("#total_tagihan").val()),
        jumlah_uang = parseInt($('[name="jumlah_uang"').val()),
        jumlah_uang_transfer = parseInt($('[name="jumlah_uang_transfer"').val());
        // diskon = parseInt($('[name="diskon"]').val());
        jumlah_uang = jumlah_uang == null ? 0 : jumlah_uang;
        jumlah_uang_transfer = jumlah_uang_transfer == null ? 0 : jumlah_uang_transfer;
    // $(".kembalian").html((jumlah_uang + jumlah_uang_transfer) - total - diskon);
    $(".kembalian").html((jumlah_uang + jumlah_uang_transfer) - total);
    console.log("Jumlah uang "+(jumlah_uang + jumlah_uang_transfer));
    console.log("total " + total);
    // console.log("diskon" +diskon);
    checkUang();
}

$("#form").validate({
    errorElement: "span",
    errorPlacement: (err, ell) => {
        err.addClass("invalid-feedback");
        ell.closest(".form-group").append(err)
    },
    submitHandler: () => {
        "edit" == url ? editData() : addData()
    }
});
$(".modal").on("hidden.bs.modal", () => {
    $("#form")[0].reset();
    $("#form").validate().resetForm()
});

// $.ajax({
//     url: readSisaUang,
//     type: 'get',
//     dataType: 'text',
//     success: (data) => {
//         $('#sisa_uang').html('Rp'+data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
//     }
// })