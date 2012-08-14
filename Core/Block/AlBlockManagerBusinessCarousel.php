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

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\AlBlockManager;
use AlphaLemon\Block\BusinessCarouselBundle\Model\AlAppBusinessCarousel;
use AlphaLemon\Block\BusinessCarouselBundle\Model\AlAppBusinessCarouselQuery;

class AlBlockManagerBusinessCarousel extends AlBlockManager
{
    public function getDefaultValue()
    {
        return array('HtmlContent' => '',
                     'InternalJavascript' => '$(".carousel").startCarousel();');
    }

    public function getHtmlContentForDeploy()
    {
        $carousel = '';
        $elements = array();
        if(class_exists('AlphaLemon\Block\BusinessCarouselBundle\Model\AlAppBusinessCarouselQuery')) {
            $items = AlAppBusinessCarouselQuery::create()->filterByBlockId($this->alBlock->getId())->find();
            foreach($items as $item) {
                $elements[] = sprintf('<li><div>%s</div><span><strong class="color1">%s %s,</strong> <br />%s</span></li>', $item->getContent(), $item->getName(), $item->getSurname(), $item->getRole());
            }

            $carousel = '<div class="carousel_container">';
            $carousel .= '<div class="carousel">';
            $carousel .= sprintf('<ul>%s</ul>', implode("\n", $elements));
            $carousel .= '</div>';
            $carousel .= '<a href="#" class="up"></a>';
            $carousel .= '<a href="#" class="down"></a>';
            $carousel .= '</div>';
        }

        return $carousel;
    }

    /**/
    public function getHtmlContent()
    {
        return $this->getHtmlContentForDeploy() . sprintf('<script type="text/javascript">%s</script>', $this->getInternalJavascript());
    }

    protected function add(array $values)
    {
        try
        {
            $this->blockRepository->startTransaction();

            // Adds the content
            $rollback = !parent::add($values);
            if(!$rollback) {

                // Adds the carousel default data
                $carousel = new AlAppBusinessCarousel();
                //$carousel->setAlBlock($this->alBlock);
                $carousel->setBlockId($this->alBlock->getId());
                $carousel->setName('John');
                $carousel->setSurname('Doe');
                $carousel->setRole('Ceo');
                $carousel->setContent('This web application is awesome!!');
                $carousel->save();
                $result = $carousel->save();
                if ($carousel->isModified() && $result == 0) $rollback = true;
            }

            // Commits or rollbacks the transaction
            if (!$rollback) {
                $this->blockRepository->commit();
                return true;
            }
            else {
                $this->blockRepository->rollBack();
                return false;
            }
        }
        catch(\Exception $e)
        {
            if(isset($this->connection) && $this->connection !== null) $this->connection->rollback();
            throw $e;
        }
    }
}