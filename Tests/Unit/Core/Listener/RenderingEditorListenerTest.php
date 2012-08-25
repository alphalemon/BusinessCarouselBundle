<?php
/*
 * This file is part of the AlphaLemon CMS Application and it is distributed
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
use AlphaLemon\Block\BusinessCarouselBundle\Core\Listener\RenderingEditorListener;


class TestBusinessCarouselEditorListener extends RenderingEditorListener
{
    protected $configureParams = null;

    public function configure()
    {
        return parent::configure();
    }
}

/**
 * AlBlockManagerBusinessCarouselTest
 *
 * @author alphalemon <webmaster@alphalemon.com>
 */
class RenderingEditorListenerTest extends TestCase
{
    public function testTheEditorHasBeenRendered()
    {
        $expectedResult = array('blockClass' => '\AlphaLemon\Block\BusinessCarouselBundle\Core\Block\AlBlockManagerBusinessCarousel');
        $listener = new TestBusinessCarouselEditorListener();
        $this->assertEquals($expectedResult, $listener->configure());
    }
}