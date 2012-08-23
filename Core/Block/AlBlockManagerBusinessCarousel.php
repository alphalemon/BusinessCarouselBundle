<?php
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

namespace AlphaLemon\Block\BusinessCarouselBundle\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlock;
use AlphaLemon\Block\BusinessCarouselBundle\Model\AlAppBusinessCarousel;
use AlphaLemon\Block\BusinessCarouselBundle\Model\AlAppBusinessCarouselQuery;

class AlBlockManagerBusinessCarousel extends AlBlockManagerJsonBlock
{
    public function getDefaultValue()
    {
        $value =
        '{
            "0" : {
                "name" : "John",
                "surname" : "Doe",
                "role" : "Ceo",
                "comment" : "This web application is really cool!"
            }
        }';

        return array('HtmlContent' => $value,
                     'InternalJavascript' => '$(".carousel").startCarousel();');
    }

    public function getHtmlContentForDeploy()
    {
        $carousel = '';
        $elements = array();
        $items = json_decode($this->alBlock->getHtmlContent());
        foreach($items as $item) {
            $elements[] = sprintf('<li><div>%s</div><span><strong class="color1">%s %s,</strong> <br />%s</span></li>', $item->comment, $item->name, $item->surname, $item->role);
        }

        if (!empty($elements)) {
            $carousel = '<div class="carousel_container">';
            $carousel .= '<div class="carousel">';
            $carousel .= sprintf('<ul>%s</ul>', implode("\n", $elements));
            $carousel .= '</div>';
            $carousel .= '<a href="#" class="up"></a>';
            $carousel .= '<a href="#" class="down"></a>';
            $carousel .= '</div>';
        }
        else
        {
            $carousel = '<p>Any item has been added</p>';
        }

        return $carousel;
    }
}