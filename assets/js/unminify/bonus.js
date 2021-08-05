function readByDate(){
    let btnSubmit = $('#submit-date');

    btnSubmit.on('click', (e)=>{
        // console.log(readDariDate);
        e.preventDefault();

        let tanggalDari = $('#tanggal_dari').val();
        let tanggalSampai = $('#tanggal_sampai').val();

        if(tanggalDari == '' || tanggalSampai == ''){
            Swal.fire("Gagal", "Mohon Lengkapi Data", "warning");
        }
        else{
            // console.log(tanggalDari, tanggalSampai);
            // ajaxCall(tanggalDari, tanggalSampai);
            totalBonusTahunan(tanggalDari, tanggalSampai);
            getBonusByDate(tanggalDari, tanggalSampai);
        }

    });
}

function getBonusByDate(tanggalDari, tanggalSampai){
    $('#laporan_bonus').dataTable().fnDestroy(); // clear datatable
        $("#laporan_bonus").DataTable({
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
            'pageLength' : 100,
            // munculin export ke excel
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'pdfHtml5',
                'print'
            ],
            order: [[1, "asc"]],
            columns:[ 
                { data: 'id_produk'},
                { data: "nama_produk"},
                { data: "qty"},
                { data: "bonus"},
                { data: "total_bonus" },
            ]
        }); // END Datatable
}

readByDate();

function ajaxCall(tanggalDari, tanggalSampai){
    $.ajax({
        url: readDariDate,
        type: 'post',
        dataType: 'json',
        data: {
            'tanggal_dari': tanggalDari,
            'tanggal_sampai': tanggalSampai
        },
        success: (data) => {
            console.log(data);
        },
        error: (err) => {
            console.log(err);
        }
    })
}

function totalBonusTahunan(tanggalDari, tanggalSampai){
    $.ajax({
        url: readDariDate,
        type: 'post',
        dataType: 'json',
        data: {
            'tanggal_dari': tanggalDari,
            'tanggal_sampai': tanggalSampai
        },
        success: (data) => {
            // console.log(data);
            let isiData = data.data;
            let totalBonus = 0;
            for(let i=0; i<isiData.length; i++){
                totalBonus += parseInt(isiData[i].total_bonus);
            }
            totalBonus = totalBonus.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            let bonusText = document.getElementById('bonus-text');
            bonusText.innerHTML = 'Total Bonus = Rp'+totalBonus;
            // console.log(totalBonus);
        },
        error: (err) => {
            console.log(err);
        }
    })
}