(function($){
    $.fn.carousel =function(visibleValue, speedValue, verticalValue, circularValue, easingValue, btnPrevValue, btnNextValue)
    {
        this.each(function() 
        {
            if(visibleValue == null) visibleValue = 1;
            if(speedValue == null) speedValue = 600;
            if(verticalValue == null) verticalValue = true;
            if(circularValue == null) circularValue = true;
            if(easingValue == null) easingValue = 'easeOutCirc';
            if(btnPrevValue == null) btnPrevValue = '.up';
            if(btnNextValue == null) btnNextValue = '.down';
            
            $(this).jCarouselLite({
                btnNext: btnNextValue,
                btnPrev: btnPrevValue,
                visible: visibleValue,
                speed: speedValue,
                vertical: verticalValue,
                circular: circularValue,
                easing: easingValue
            });
        });
    }
})($);

