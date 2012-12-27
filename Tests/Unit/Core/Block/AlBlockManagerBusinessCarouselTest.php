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

namespace AlphaLemon\Block\BusinessCarouselBundle\Tests\Unit\Core\Block;

use AlphaLemon\Block\BusinessCarouselBundle\Tests\TestCase;
use AlphaLemon\Block\BusinessCarouselBundle\Core\Block\AlBlockManagerBusinessCarousel;

/**
 * AlBlockManagerBusinessCarouselTest
 *
 * @author alphalemon <webmaster@alphalemon.com>
 */
class AlBlockManagerBusinessCarouselTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $factoryRepository = $this->getMock('AlphaLemon\AlphaLemonCmsBundle\Core\Repository\Factory\AlFactoryRepositoryInterface');
        $eventsHandler = $this->getMock('AlphaLemon\AlphaLemonCmsBundle\Core\EventsHandler\AlEventsHandlerInterface');
        $this->blockManager = new AlBlockManagerBusinessCarousel($eventsHandler, $factoryRepository);
    }

    public function testDefaultValue()
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
        $expectedValue = array(
            'Content' => $value,
            'InternalJavascript' => '$(".carousel").startCarousel();',);
        $this->assertEquals($expectedValue, $this->blockManager->getDefaultValue());
    }

    public function testAnEmptyStringIsReturnedWhenTheBlockHasNotBeenSet()
    {
        $this->assertEquals('', $this->blockManager->getHtml());
    }

    public function testTheCarouselIsRendered()
    {
        $block = $this->setUpBlock();
        $this->blockManager->set($block);
        $content = $this->blockManager->getHtml();
        
        $expectedResult = array
        (
            "RenderView" => array
            (
                "view" => "BusinessCarouselBundle:Carousel:carousel.html.twig",
                "options" => array
                (
                    "items" => array
                    (
                        array
                        (
                            "name" => "John",
                            "surname" => "Doe",
                            "role" => "Ceo",
                            "comment" => "This web application is really cool!",
                        ),
                        array
                        (
                            "name" => "Jane",
                            "surname" => "Doe",
                            "role" => "Art Director",
                            "comment" => "Amazing web app!",
                        ),

                    ),

                ),

            ),

        );

        $this->assertEquals($expectedResult, $content);
    }

    public function testGetHideInEditMode()
    {
        $this->assertTrue($this->blockManager->getHideInEditMode());
    }

    private function setUpBlock()
    {
        $value =
        '{
            "0" : {
                "name" : "John",
                "surname" : "Doe",
                "role" : "Ceo",
                "comment" : "This web application is really cool!"
            },
            "1" : {
                "name" : "Jane",
                "surname" : "Doe",
                "role" : "Art Director",
                "comment" : "Amazing web app!"
            }
        }';

        $block = $this->getMock('AlphaLemon\AlphaLemonCmsBundle\Model\AlBlock');
        $block->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue($value));

        return $block;
    }
}