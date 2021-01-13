let laporan_keuangan = $("#laporan_keuangan").DataTable( {
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
    order:[
        [1, "asc"]],
        columns:[ {
            data: null
        },
        {
            data: "tgl_input"
        },
        {
            data: "keterangan_kas"
        },
        {
            data: "debet"
        },
        {
            data: "kredit"
        },
        
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

console.log('olae');