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
        $dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->blockManager = new AlBlockManagerBusinessCarousel($dispatcher, $factoryRepository);
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
            'HtmlContent' => $value,
            'InternalJavascript' => '$(".carousel").startCarousel();',);
        $this->assertEquals($expectedValue, $this->blockManager->getDefaultValue());
    }

    public function testAnEmptyStringIsReturnedWhenTheBlockHasNotBeenSet()
    {
        $this->assertEquals('', $this->blockManager->getHtmlContentForDeploy());
    }

    public function testTheCarouselIsRendered()
    {
        $block = $this->setUpBlock();
        $this->blockManager->set($block);
        $content = $this->blockManager->getHtmlContentForDeploy();

        $expectedResult = '<div class="carousel_container"><div class="carousel"><ul><li><div>This web application is really cool!</div><span><strong class="color1">John Doe,</strong> <br />Ceo</span></li>' . PHP_EOL;
        $expectedResult .= '<li><div>Amazing web app!</div><span><strong class="color1">Jane Doe,</strong> <br />Art Director</span></li></ul></div><a href="#" class="up"></a><a href="#" class="down"></a></div>';
        $this->assertEquals($expectedResult, $content);
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
            ->method('getHtmlContent')
            ->will($this->returnValue($value));

        return $block;
    }
}