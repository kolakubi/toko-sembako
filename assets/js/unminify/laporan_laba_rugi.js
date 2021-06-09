// $.ajax({
//     url: readSisaUang,
//     type: 'get',
//     dataType: 'text',
//     success: (data) => {
//         $('#sisa_uang').html('Rp'+data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
//     }
// })

// $.ajax({
//     url: readSisaUangTransfer,
//     type: 'get',
//     dataType: 'text',
//     success: (data) => {
//         $('#sisa_uang_transfer').html('Rp'+data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
//     }
// })

function readByDate(){
    let btnSubmit = $('#submit-date');

    btnSubmit.on('click', (e)=>{
        e.preventDefault();

        let tanggalDari = $('#tanggal_dari').val();
        let tanggalSampai = $('#tanggal_sampai').val();

        getDataLabaRugi(tanggalDari, tanggalSampai);
        
    });
}

function getDataLabaRugi(tanggalDari, tanggalSampai){
    $.ajax({
        url: readModif,
        type:"post",
        dataType:"json",
        data: {
            tanggal_dari: tanggalDari, 
            tanggal_sampai: tanggalSampai
        },
        success: res=> {
            console.log(res['data_laba_rugi']);
            // isi datatables
            isiDataTable(res['data']);

            // hitung laba / rugi
            isiLabaRugi(res['data_laba_rugi']);
        },
        error: (err) =>{
            console.log(err);
        }
    });
}

function isiLabaRugi(data){
    const rugiElem = $('#rugi');
    const labaElem = $('#laba');
    const pembelianElem = $('#modal');
    const penjualanElem = $('#total_penjualan');
    const oprasionalElem = $('#total_oprasional');

    const pembelian = data.pembelian;
    const penjualan = data.penjualan;
    const oprasional = data.oprasional;

    const hasilAkhir = penjualan-(pembelian+oprasional);

    pembelianElem.html('Rp'+pembelian.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    penjualanElem.html('Rp'+penjualan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    oprasionalElem.html('Rp'+oprasional.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

    // jika rugi
    if(hasilAkhir < 0){
        rugiElem.html('Rp'+hasilAkhir.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }
    else{ // jika laba
        labaElem.html('Rp'+hasilAkhir.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }
}

function isiDataTable(dataLabaRugi){
    // console.log(tanggalDari, tanggalSampai);

    $('#laporan_keuangan').dataTable().fnDestroy(); // clear datatable
    $("#laporan_keuangan").DataTable({
        responsive:true,
        scrollX:true,
        // ajax: {
        //     url: readModif,
        //     type: 'post',
        //     data: {
        //         'tanggal_dari': tanggalDari,
        //         'tanggal_sampai': tanggalSampai
        //     }
        // },
        data: dataLabaRugi,
        columnDefs:[{
            searcable: true,
            orderable: true,
            targets: 0
        }],
        'pageLength' : 100,
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

readByDate();

// $.ajax({
//     url: readModif,
//     type:"post",
//     dataType:"json",
//     data: {
//         tanggal_dari: '2021-06-08', 
//         tanggal_sampai: '2021-06-08'
//     },
//     success:res=> {
//         console.log(res);
//     },
//     error: (err) =>{
//         console.log(err)
//     }
// });