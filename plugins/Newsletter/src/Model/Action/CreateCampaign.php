<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 26-5-16
 * Time: 15:21
 */

use Newsletter\Model\Table\CampaignsTable;
use Newsletter\Model\Entity\Campaign;
use Newsletter\Model\Entity\Template;

class CreateCampaign{

    protected $campaignsTable;

    public function __construct(CampaignsTable $campagins)
    {
        $this->campaignsTable = $campagins;
    }

    public function __invoke(Campaign $entity, Template $template, array $properties)
    {
        $entity = $this->campaignsTable->patchEntity($entity, $properties);
        $entity->template = $template;
        $entity->status = 'new';
        $this->campaignsTable->save($entity, ['associated' => 'Templates']);

        return $entity;
    }
}
