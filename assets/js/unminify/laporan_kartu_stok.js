// $.ajax( {
//     url:laporanUrl,
//     type:"get",
//     dataType:"json",
//     success:res=> {
//         console.log(res);
//     }
// });

// let laporan_stok_masuk=$("#laporan_kartu_stok").DataTable( {
//     responsive:true,
//     scrollX:true,
//     ajax:laporanUrl,
//     columnDefs:[ {
//         searcable: true,
//         orderable: true,
//         targets: 0
//     }],
//     // 'pageLength' : 60,
//     // munculin export ke excel
//     dom: 'Bfrtip',
//     buttons: [
//         'excelHtml5',
//         'pdfHtml5',
//         'print'
//     ],
//     order:[
//         [1, "desc"]],
//     columns:[ 
//         { data: null },
//         { data: "tanggal" },
//         { data: "nama" },
//         { data: "masuk" },
//         { data: "keluar" },
//         { data: "keterangan" }
//     ]
// }

// );
// function reloadTable() {
//     laporan_stok_masuk.ajax.reload()
// }

// function remove(id) {
//     Swal.fire( {
//         title: "Hapus",
//         text: "Hapus data ini?",
//         type: "warning",
//         showCancelButton: true
//     }).then(()=> {
//         $.ajax( {
//             url:deleteUrl,
//             type:"post",
//             dataType:"json",
//             data: {
//                 id: id
//             },
//             success:()=> {
//                 Swal.fire("Sukses", "Sukses Menghapus Data", "success");
//                 reloadTable()
//             },
//             error:err=> {
//                 console.log(err)
//             }
//         })
//     })
// }

// laporan_stok_masuk.on("order.dt search.dt", ()=> {
//     laporan_stok_masuk.column(0, {
//         search: "applied",
//         order: "applied"
//     }).nodes().each((el, err)=> {
//         el.innerHTML=err+1
//     })
// });
// $(".modal").on("hidden.bs.modal", ()=> {
//     $("#form")[0].reset();
//     $("#form").validate().resetForm()
// });

$.ajax( {
    url:data_stokUrl,
    type:"get",
    dataType:"json",
    success:res=> {
        $.each(res, (key, index)=> {
            let html=`<li class="list-group-item">
                ${index.nama_produk}
                <span class="float-right">${index.stok}</span>
            </li>`;
            $("#stok_produk").append(html)
        })
    }
});

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
            // $("#sisa").html(`Sisa ${res.stok}`);
            // checkEmpty()
        },
        error: err => {
            console.log(err)
        }
    })
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

$('#submit-date').on('click', (e)=>{
    e.preventDefault();
    let tanggalDari = $('#tanggal_dari').val();
    let tanggalSampai = $('#tanggal_sampai').val();
    let idProduk = $('#barcode').val();

    console.log(tanggalDari, tanggalSampai, idProduk);

    if(tanggalDari != '' && tanggalSampai != '' && idProduk != null){
        // console.log(tanggalDari, tanggalSampai, idProduk);

        $('#laporan_kartu_stok').dataTable().fnDestroy(); // clear datatable
        $("#laporan_kartu_stok").DataTable({
            responsive:true,
            scrollX:true,
            ajax: {
                url: getStokDariDate,
                type: 'post',
                data: {
                    'tanggal_dari': tanggalDari,
                    'tanggal_sampai': tanggalSampai,
                    'id_produk': idProduk
                }
            },
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
            order: [
                [1, "asc"]],
                columns:[ 
                    { data: 'nomor'},
                    { data: "tanggal"},
                    { data: "nama"},
                    { data: "masuk"},
                    { data: "keluar" },
                    { data: "orang"},
                    { data: "keterangan" },
                ]
        }); // END Datatable
    }
    else{
        Swal.fire("Kesalahan", "Mohon lengkapi form", "warning")
    }
})

// $.ajax( {
//     url: getStokDariDate,
//     type:"post",
//     dataType:"text",
//     data: {
//         tanggal_dari: '2021-03-01', 
//         tanggal_sampai: '2021-03-15',
//         id_produk: '21647',
//     },
//     success:res=> {
//         console.log(res);
//     },
//     error: (err) =>{
//         console.log(err)
//     }
// });