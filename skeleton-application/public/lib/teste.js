(function($){
    $.fn.teste = function(options) {
        var settings = $.extend({
            //obrigatorios
            url: "",
            
            //opcionais
            validate_password: true,
        }, options );

        var _this = this;

        var testeFun = function ($a,$b){
            console.log($a+' -- '+$b);
        }

        return {
            init: function(){
                alert(settings.url);
                testeFun(1,34);
            }
        }
    }
}( jQuery ));