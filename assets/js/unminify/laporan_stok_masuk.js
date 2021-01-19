// let laporan_stok_masuk=$("#laporan_stok_masuk").DataTable( {
//     responsive:true,
//     scrollX:true,
//     ajax:laporanUrl,
//     columnDefs:[ {
//         searcable: true,
//         orderable: true,
//         targets: 0
//     }],
//     'pageLength' : 60,
//     // munculin export ke excel
//     dom: 'Bfrtip',
//     buttons: [
//         'excelHtml5',
//         'pdfHtml5',
//         'print'
//     ],
//     order:[[1, "desc"]],
//     columns:[ 
//         {data: null}, 
//         {data: "tanggal"}, 
//         {data: "nama_produk"}, 
//         {data: "jumlah"}, 
//         {data: "keterangan"}, 
//         {data: "supplier"},
//         {data: "harga"}
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

// $.ajax( {
//     url:data_stokUrl,
//     type:"get",
//     dataType:"json",
//     success:res=> {
//         $.each(res, (key, index)=> {
//             let html=`<li class="list-group-item">
//                 ${index.nama_produk}
//                 <span class="float-right">${index.stok}</span>
//             </li>`;
//             $("#stok_produk").append(html)
//         })
//     }
// });

function readByDate(){
    let btnSubmit = $('#submit-date');

    btnSubmit.on('click', (e)=>{
        e.preventDefault();

        let tanggalDari = $('#tanggal_dari').val();
        let tanggalSampai = $('#tanggal_sampai').val();

        console.log(tanggalDari, tanggalSampai);

        $('#laporan_stok_masuk').dataTable().fnDestroy(); // clear datatable
        $("#laporan_stok_masuk").DataTable({
            responsive:true,
            scrollX:true,
            ajax: {
                url: readDariDate,
                type: 'post',
                data: {
                    'tanggal_dari': tanggalDari,
                    'tanggal_sampai': tanggalSampai
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
                    {data: "nomor"}, 
                    {data: "tanggal"}, 
                    {data: "nama_produk"}, 
                    {data: "jumlah"}, 
                    {data: "keterangan"}, 
                    {data: "supplier"},
                    {data: "harga"}
                ]
        }); // END Datatable

        // $.ajax({
        //     url: readUrl,
        //     type: 'post',
        //     dataType: 'json',
        //     data: {
        //         'tanggal_dari': tanggalDari,
        //         'tanggal_sampai': tanggalSampai
        //     },
        //     success: (data) => {
        //         console.log(data);
        //     },
        //     error: (err) => {
        //         console.log(err);
        //     }
        // })
    });
}

readByDate();