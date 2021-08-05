$(".modal").on("hidden.bs.modal", ()=> {
    $("#form")[0].reset();
    $("#form").validate().resetForm()
});

function readByDate(){
    let btnSubmit = $('#submit-date');

    btnSubmit.on('click', (e)=>{
        // console.log(readDariDate);
        e.preventDefault();

        let tanggalDari = $('#tanggal_dari').val();
        let tanggalSampai = $('#tanggal_sampai').val();

        // console.log(tanggalDari, tanggalSampai);

        if(tanggalDari == '' || tanggalSampai == ''){
            Swal.fire("Gagal", "Mohon Lengkapi Data", "warning");
        }
        else{
            $('#laporan_penjualan').dataTable().fnDestroy(); // clear datatable
            $("#laporan_penjualan").DataTable({
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
                        { data: 'nomor'},
                        { data: "tanggal"},
                        { data: "nama_produk"},
                        { data: "total_bayar"},
                        { data: "jumlah_uang" },
                        { data: "pelanggan" },
                        { data: "action" },
                    ]
            }); // END Datatable
        }
        // $.ajax({
        //     url: readDariDate,
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