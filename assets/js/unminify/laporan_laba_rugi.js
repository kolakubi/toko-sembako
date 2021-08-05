async function ambilSisaUang(){
    const sisaUangCash = await fetch(readSisaUangCash)
        .then(response => response.json())
        .then(data => {return data});

    const sisaUangTransfer = await fetch(readSisaUangTransfer)
        .then(response => response.json())
        .then(data => {return data});

    const sisaUang = await sisaUangCash+sisaUangTransfer;
    return sisaUang;
    // $('#sisa_uang').html('Rp'+sisaUang.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
}

async function ambilNilaiSisaStok(){
    let totalNilaiStok = 0;

    const nilaiSisaStok = await fetch(readNilaiSisaStok)
        .then(response => response.json())
        .then(data => {return data});

    nilaiSisaStok.forEach(data => {
        totalNilaiStok += data.jumlah_stok*data.harga_beli
    });

    return totalNilaiStok

    // $('#nilai_sisa_stok').html('Rp'+totalNilaiStok.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
}

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

async function isiLabaRugi(data){
    const rugiElem = $('#rugi');
    const labaElem = $('#laba');
    const pembelianElem = $('#total_pembelian');
    const penjualanElem = $('#total_penjualan');
    const oprasionalElem = $('#total_oprasional');
    const modallElem = $('#modal');

    const pembelian = data.pembelian;
    const penjualan = data.penjualan;
    const oprasional = data.oprasional;
    const modal = data.modal;

    // const hasilAkhir = modal+penjualan-(pembelian+oprasional);
    const hasilAkhir = penjualan-pembelian-oprasional;

    pembelianElem.html('Rp'+pembelian.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    penjualanElem.html('Rp'+penjualan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    oprasionalElem.html('Rp'+oprasional.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    modallElem.html('Rp'+modal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    
    let nilaiSisaStok = 0;
    await ambilNilaiSisaStok()
            .then((res)=>{
                nilaiSisaStok=res;
                $('#nilai_sisa_stok').html('Rp'+res.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });
    
    let sisaUang = 0;
    await ambilSisaUang()
            .then((res)=>{
                sisaUang=res;
                $('#sisa_uang').html('Rp'+res.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });
    
    const laba = (nilaiSisaStok+sisaUang)-modal;

    // jika rugi
    if(laba < 0){
        rugiElem.html('Rp'+laba.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }
    else{ // jika laba
        labaElem.html('Rp'+laba.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }
}

function isiDataTable(dataLabaRugi){

    $('#laporan_keuangan').dataTable().fnDestroy(); // clear datatable
    $("#laporan_keuangan").DataTable({
        responsive:true,
        scrollX:true,
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
//     dataType:"text",
//     data: {
//         tanggal_dari: '2021-06-08', 
//         tanggal_sampai: '2021-06-14'
//     },
//     success:res=> {
//         console.log(res);
//     },
//     error: (err) =>{
//         console.log(err)
//     }
// });