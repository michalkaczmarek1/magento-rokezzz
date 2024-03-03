<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Block\Adminhtml;

use Magento\Backend\Block\Widget\Context;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    /**
     *
     * @param Context $context
     * @param TypeOrderRepositoryInterface $typeOrderRepository
     */
    public function __construct(
        private readonly Context                      $context,
        private readonly TypeOrderRepositoryInterface $typeOrderRepository
    ) {
    }

    /**
     *
     * @return string|null
     */
    public function getTypeOrderId(): ?string
    {
        try {
            return $this->typeOrderRepository->getById(
                (int)$this->context->getRequest()->getParam('type_order_id')
            )->getTypeOrderId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
