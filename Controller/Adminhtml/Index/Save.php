<?php
/**
 * Pashko_ZipLookup
 *
 * @category ZipLookup
 * @package Pashko_ZipLookup
 * @author Ostap Pashko <ostap.paashko@gmail.com>
 */

namespace Pashko\ZipLookup\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Pashko\ZipLookup\Api\ZipRepositoryInterface;
use Pashko\ZipLookup\Model\ZipFactory;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Pashko_ZipLookup::manage';

    /**
     * @var ZipFactory
     */
    protected $zipFactory;
    /**
     * @var ZipRepositoryInterface
     */
    protected $zipRepository;

    /**
     * Save constructor.
     * @param Context $context
     * @param ZipFactory $zipFactory
     */
    public function __construct(
        Context $context,
        ZipFactory $zipFactory,
        ZipRepositoryInterface $zipRepository
    ) {
        parent::__construct($context);
        $this->zipFactory = $zipFactory;
        $this->zipRepository = $zipRepository;
    }

    /**
     * Execute action based on request and return result
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     */
    public function execute()
    {
        try {
            if ($this->getRequest()->isPost()) {
                $input = $this->getRequest()->getPostValue()["zip"];
                $zipRecord = $this->zipFactory->create();
                if (isset($input['entity_id'])) {
                    $zipRecord->load($input['entity_id']);
                    $zipRecord->addData($input);
                } else {
                    $zipRecord->setData($input);
                }
                $this->zipRepository->save($zipRecord);

                return $this->_redirect('*/index/index');
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->_redirect('*/index/index');
        }
    }
}
