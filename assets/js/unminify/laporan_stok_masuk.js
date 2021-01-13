let laporan_stok_masuk=$("#laporan_stok_masuk").DataTable( {
    responsive:true,
    scrollX:true,
    ajax:laporanUrl,
    columnDefs:[ {
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
    order:[
        [1, "desc"]],
        columns:[ {
        data: null
    }
    , {
        data: "tanggal"
    }
    , {
        data: "barcode"
    }
    , {
        data: "nama_produk"
    }
    , {
        data: "jumlah"
    }
    , {
        data: "keterangan"
    }
    , {
        data: "supplier"
    },
    {
        data: "harga"
    }
    ]
}

);
function reloadTable() {
    laporan_stok_masuk.ajax.reload()
}

function remove(id) {
    Swal.fire( {
        title: "Hapus",
        text: "Hapus data ini?",
        type: "warning",
        showCancelButton: true
    }).then(()=> {
        $.ajax( {
            url:deleteUrl,
            type:"post",
            dataType:"json",
            data: {
                id: id
            },
            success:()=> {
                Swal.fire("Sukses", "Sukses Menghapus Data", "success");
                reloadTable()
            },
            error:err=> {
                console.log(err)
            }
        })
    })
}

laporan_stok_masuk.on("order.dt search.dt", ()=> {
    laporan_stok_masuk.column(0, {
        search: "applied",
        order: "applied"
    }).nodes().each((el, err)=> {
        el.innerHTML=err+1
    })
});
$(".modal").on("hidden.bs.modal", ()=> {
    $("#form")[0].reset();
    $("#form").validate().resetForm()
});