/*
 * This file is part of the BusinessCarouselBundle and it is distributed
 * under the GPL LICENSE Version 2.0. To use this application you must leave
 * intact this copyright notice.
 *
 * Copyright (c) AlphaLemon <webmaster@alphalemon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.alphalemon.com
 *
 * @license    GPL LICENSE Version 2.0
 *
 */

(function($){
    $.fn.startCarousel =function(visibleValue, speedValue, verticalValue, circularValue, easingValue, btnPrevValue, btnNextValue)
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

