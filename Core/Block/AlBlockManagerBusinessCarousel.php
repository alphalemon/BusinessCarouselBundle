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

        return array(
            'Content' => $value,
            'InternalJavascript' => '$(".carousel").startCarousel();'
        );
    }

    public function getHtml()
    {
        if (null === $this->alBlock) {
            return "";
        }
        
        $items = json_decode($this->alBlock->getContent(), true);
        
        return array(
            "RenderView" => array(
                "view" => "BusinessCarouselBundle:Carousel:carousel.html.twig",
                "options" => array(
                    "items" => $items,
                )
            )
        );
    }

    public function getHideInEditMode()
    {
        return true;
    }
}