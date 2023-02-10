<?php

declare(strict_types=1);

namespace Pointeger\Cookie\Model\Config\Source;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class BlocksDropDown
 * @package Pointeger\Cookie\Model\Config\Source
 */
class BlocksDropDown implements OptionSourceInterface
{
    /**
     * @var BlockRepositoryInterface
     */
    protected $blockRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;
    /**
     * @var SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * BlocksDropDown constructor.
     * @param BlockRepositoryInterface $blockRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        BlockRepositoryInterface $blockRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        $this->blockRepository = $blockRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @return array|array[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function toOptionArray()
    {
        $identifiers = [
            ['value' => '', 'label' => __('-- Select an Option --')]
        ];
        $cmsBlocks = $this->getCmsBlocks();
        foreach ($cmsBlocks as $cmsBlock) {
            if ($cmsBlock->isActive()) {
                $identifiers[] =
                    ['value' => $cmsBlock->getIdentifier(), 'label' => __($cmsBlock->getTitle())];
            }
        }
        return $identifiers;
    }

    /**
     * @return \Magento\Cms\Api\Data\BlockInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCmsBlocks()
    {
        $sortOrder = $this->sortOrderBuilder->setField('block_id')->setDirection('DESC')->create();
        $searchCriteria = $this->searchCriteriaBuilder->addSortOrder($sortOrder)->create();
        $cmsBlocks = $this->blockRepository->getList($searchCriteria)->getItems();
        return $cmsBlocks;
    }
}
