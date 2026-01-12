jQuery(function($) {
    $("#ordermobil").submit(function(e){
        $('.respon').html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat bi-spin" viewBox="0 0 16 16"><path d="M11.534 7h2.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-4.602 2H4a.25.25 0 0 1-.192-.41l1.966-2.36a.25.25 0 0 1 .384 0l1.966 2.36a.25.25 0 0 1-.192.41z"/><path fill-rule="evenodd" d="M8 3a5 5 0 0 0-4.546 2.914.5.5 0 1 1-.908-.418A6 6 0 0 1 8 2z"/><path fill-rule="evenodd" d="M8 13a5 5 0 0 0 4.546-2.914.5.5 0 0 1 .908.418A6 6 0 0 1 8 14z"/></svg>');
        var konten = $("form").serialize();
        jQuery.ajax({
                type    : "POST",
                url     : ajaxurl,
                data    : {action:'onsubmit', data:konten },  
                success :function(data) {
                    $('.respon').html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M6.97 11.03a.75.75 0 0 0 1.07 0l3.992-3.992a.75.75 0 1 0-1.06-1.06L7.5 9.439 5.53 7.47a.75.75 0 0 0-1.06 1.06z"/></svg>');
                    setTimeout(function() {
                        $('.respon').html(data);
                    }, 500);                    
            },
        });
        e.preventDefault();
    });
    
    function convertToRupiah(angka)
    {
    	var rupiah = '';		
    	var angkarev = angka.toString().split('').reverse().join('');
    	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    	return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    }
    
    $("#tipe").chained("#mobil");

    $("#hitungsimulasi").click(function(event) {
        $('.form-simulasikredit-alert').html('');
        var response        = $("#recaptchaSimulasiform").length !== 0 ? grecaptcha.getResponse() : '99' ;
        
        if(response.length !== 0) {
        
            var harga           = $('#tipe').val();
            var tenor           = $('#tenor').val();
            var tenortahun      = tenor*12;
            var dp              = $('#dp').val();
            var kurang          = +harga - +dp;
            var angsuran        = kurang/tenortahun;
            var totaldp         = dp;
            var tpinjaman       = '<div class="alert alert-dark" role="alert"> Total Pinjaman: '+ convertToRupiah(Math.round(kurang)) +'</div>';
            var tuangmuka       = '<div class="alert alert-dark" role="alert">Total Uang Muka (DP): '+convertToRupiah(Math.round(totaldp))+'</div>';
            var tangsuran       = '<div class="alert alert-info" role="alert">Angsuran per bulan<br><b>'+convertToRupiah(Math.round(angsuran))+'</b><small>*selama '+tenor+' tahun ('+tenortahun+' Bulan)</small></div>';
            if(!harga){
                $('.hasilhitung').html('<div class="alert alert-warning" role="alert">Mobil dan tipe belum dipilih.</div>');
            } else if (!dp){
                $('.hasilhitung').html('<div class="alert alert-warning" role="alert">Tentukan DP. Contoh 80.000.000</div>');
            } else {
                $('.hasilhitung').html('<div class="">'+  tpinjaman + tuangmuka + tangsuran + '</div>');
            }
            
        } else {
            var msg = '';
            if ($("#recaptchaSimulasiform").length !== 0) {
                msg += 'Please verify recaptcha';
            } else {
                msg += 'Please try again';
            }
            $('.form-simulasikredit-alert').html('<div class="alert alert-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill me-1" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.964 0L.165 13.233c-.457.778.091 1.767.982 1.767h13.706c.89 0 1.438-.99.982-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1-2.002 0 1 1 0 0 1 2.002 0"/></svg>'+msg+'</div>');
        }
        event.preventDefault();
    });
    printArea = function(elem){
        $("#"+elem).printArea({
            mode    :"iframe"
        });
    }
});
