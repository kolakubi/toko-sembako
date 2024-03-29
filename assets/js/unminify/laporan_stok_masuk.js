function readByDate(){
    let btnSubmit = $('#submit-date');

    btnSubmit.on('click', (e)=>{
        e.preventDefault();

        let tanggalDari = $('#tanggal_dari').val();
        let tanggalSampai = $('#tanggal_sampai').val();

        // console.log(tanggalDari, tanggalSampai);

        if(tanggalDari == '' || tanggalSampai == ''){
            Swal.fire("Gagal", "Mohon Lengkapi Data", "warning");
        }
        else{
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
                        // {data: "jumlah"}, 
                        {data: "keterangan"}, 
                        {data: "supplier"},
                        {data: "harga"}
                    ]
            }); // END Datatable
        }
    });
}

readByDate();