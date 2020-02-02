(function () {
    'use-strict';
    const incRegister = ( function(){
        let privateMethod = function(){
            return 'I am private';
        }

        return {
            init : function(){
                console.log('I am public');
            }
        }
    })();

    incRegister.init();
})();




