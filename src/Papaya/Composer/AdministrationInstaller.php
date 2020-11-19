<?php

namespace Papaya\Composer {

  use Composer\Package\PackageInterface;
  use Composer\Repository\InstalledRepositoryInterface;

  class AdministrationInstaller extends PapayaInstaller {

    public function install(
      InstalledRepositoryInterface $repo, PackageInterface $package
    ) {
      $this->validateUnique($repo, $package);
      return parent::install($repo, $package);
    }

    public function validateUnique(
      InstalledRepositoryInterface $repo,
      PackageInterface $current
    ) {
      foreach ($repo->getPackages() as $package) {
        if ($package->getType() === 'papaya-administration-ui') {
          throw new \InvalidArgumentException(
            'Can not install package '.$current->getPrettyName().'.'.
            ' Only a single papaya-administration-ui package can be installed.'.
            ' Already installed: '.$package->getPrettyName()
          );
        }
      }
    }

    public function getInstallPath(PackageInterface $package) {
      return $this->getDocumentRoot().'papaya';
    }

    public function supports($packageType) {
      return 'papaya-administration-ui' === $packageType;
    }
  }
}
