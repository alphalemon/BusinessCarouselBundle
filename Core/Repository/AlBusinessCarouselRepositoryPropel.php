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

namespace AlphaLemon\Block\BusinessCarouselBundle\Core\Repository;

use AlphaLemon\AlphaLemonCmsBundle\Core\Event\Query\Content;
use AlphaLemon\AlphaLemonCmsBundle\Core\Event\Query\ContentsEvents;
use AlphaLemon\AlphaLemonCmsBundle\Core\Exception\Content\General;
use AlphaLemon\AlphaLemonCmsBundle\Model\AlBlock;
use AlphaLemon\AlphaLemonCmsBundle\Model\AlBlockQuery;
use AlphaLemon\AlphaLemonCmsBundle\Core\Repository\Repository\BlockRepositoryInterface;
use AlphaLemon\AlphaLemonCmsBundle\Core\Exception\Content\General\InvalidParameterTypeException;
use AlphaLemon\Block\BusinessCarouselBundle\Model\AlAppBusinessCarousel;
use AlphaLemon\AlphaLemonCmsBundle\Core\Repository\Propel\Base\AlPropelRepository;

/**
 *  
 *
 *  @author alphalemon <webmaster@alphalemon.com>
 */
class AlBusinessCarouselRepositoryPropel extends AlPropelRepository
{
    /**
     * {@inheritdoc}
     */
    public function getRepositoryObjectClassName()
    {
        return '\AlphaLemon\Block\BusinessCarouselBundle\Core\Model\AlAppBusinessCarousel';
    }

    /**
     * {@inheritdoc}
     */
    public function setRepositoryObject($object = null)
    {
        if (null !== $object && !$object instanceof AlAppBusinessCarousel) {
            throw new InvalidParameterTypeException('AlBusinessCarouselRepositoryPropel accepts only AlAppBusinessCarousel propel objects');
        }

        return parent::setRepositoryObject($object);
    }
}
