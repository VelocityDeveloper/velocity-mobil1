jQuery(function($) {
    $("#ordermobil").submit(function(e){
        $('.respon').html('<i class="fa fa-spinner fa-spin"></i>');
        var konten = $("form").serialize();
        jQuery.ajax({
                type    : "POST",
                url     : ajaxurl,
                data    : {action:'onsubmit', data:konten },  
                success :function(data) {
                    $('.respon').html('<i class="fa fa-check-circle"></i>');
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
            var bunga           = $('#bunga').val();
            var dp              = $('#dp').val();
            var kurang          = +harga - +dp;
            var bungadibayar    = +kurang*((bunga*tenor)/100);
            var angsuran        = (kurang+bungadibayar)/tenortahun;
            var totaldp         = + dp + +angsuran;
            var tpinjaman       = '<div class="alert alert-dark" role="alert"> Total Pinjaman: '+ convertToRupiah(Math.round(kurang)) +'</div>';
            var tuangmuka       = '<div class="alert alert-dark" role="alert">Total Uang Muka (DP): '+convertToRupiah(Math.round(totaldp))+'</div>';
            var tangsuran       = '<div class="alert alert-info" role="alert">Angsuran per bulan<br><b>'+convertToRupiah(Math.round(angsuran))+'</b><small>*selama '+tenor+' tahun ('+tenortahun+' Bulan)</small></div>';
            if(!harga){
                $('.hasilhitung').html('<div class="alert alert-warning" role="alert">Mobil dan tipe belum dipilih.</div>');
            } else if (!dp){
                $('.hasilhitung').html('<div class="alert alert-warning" role="alert">Tentukan DP. Contoh 80.000.000</div>');
            } else if (!bunga) {
                $('.hasilhitung').html('<div class="alert alert-warning" role="alert">Tentukan Bunga. Contoh 10</div>');
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
            $('.form-simulasikredit-alert').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> '+msg+'</div>');
        }
        event.preventDefault();
    });
    printArea = function(elem){
        $("#"+elem).printArea({
            mode    :"iframe"
        });
    }
});