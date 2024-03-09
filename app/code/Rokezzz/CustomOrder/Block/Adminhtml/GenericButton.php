<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Block\Adminhtml;

use Magento\Backend\Block\Widget\Context;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    public function __construct(
        private readonly Context                      $context,
        private readonly TypeOrderRepositoryInterface $typeOrderRepository
    ) {
    }

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

    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
