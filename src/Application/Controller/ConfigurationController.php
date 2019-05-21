<?php

namespace App\Application\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ConfigurationController
 * @package App\Application\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class ConfigurationController extends AbstractController
{

}