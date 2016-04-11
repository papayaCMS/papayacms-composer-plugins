<?php

namespace Papaya\Composer {

  use Composer\Package\PackageInterface;

  class TemplateInstaller extends PapayaInstaller {

    public function getInstallPath(PackageInterface $package) {
      $name = substr(
        strrchr($package->getPrettyName(), '/template-'),
        10
      );
      if (empty($name)) {
        throw new \InvalidArgumentException(
          'Unable to install template, empty directory name."'
        );
      }
      return $this->getTemplateDirectory().$name;
    }

    public function supports($packageType) {
      return 'papaya-template' === $packageType;
    }
  }
}