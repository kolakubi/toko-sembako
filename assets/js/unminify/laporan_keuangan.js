$.ajax({
    url: readSisaUang,
    type: 'get',
    dataType: 'text',
    success: (data) => {
        $('#sisa_uang').html('Rp'+data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
    }
})

$.ajax({
    url: readSisaUangTransfer,
    type: 'get',
    dataType: 'text',
    success: (data) => {
        $('#sisa_uang_transfer').html('Rp'+data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
    }
})

function readByDate(){
    let btnSubmit = $('#submit-date');

    btnSubmit.on('click', (e)=>{
        e.preventDefault();

        let tanggalDari = $('#tanggal_dari').val();
        let tanggalSampai = $('#tanggal_sampai').val();

        if(tanggalDari == '' || tanggalSampai == ''){
            Swal.fire("Gagal", "Mohon Lengkapi Data", "warning");
        }
        else{
            $('#laporan_keuangan').dataTable().fnDestroy(); // clear datatable
            $("#laporan_keuangan").DataTable({
                responsive:true,
                scrollX:true,
                ajax: {
                    url: readModif,
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
                        { data: "tgl_input"},
                        { data: 'orang'},
                        { data: 'nama_produk'},
                        { data: "metode_pembayaran"},
                        { data: "debet" },
                        { data: "kredit" },
                    ]
            }); // END Datatable
        }
    });
}

readByDate();

// $.ajax({
//     url: readModif,
//     type:"post",
//     dataType:"json",
//     data: {
//         tanggal_dari: '2021-02-01', 
//         tanggal_sampai: '2021-02-01'
//     },
//     success:res=> {
//         console.log(res);
//     },
//     error: (err) =>{
//         console.log(err)
//     }
// });