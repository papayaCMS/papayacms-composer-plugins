<?php

namespace Papaya\Composer {

  use Composer\Package\PackageInterface;
    use InvalidArgumentException;

    class ThemeInstaller extends PapayaInstaller {

    public function getInstallPath(PackageInterface $package) {
      $name = substr(
        strrchr($package->getPrettyName(), '/'),
        1
      );
      if (0 === 'theme-') {
        $name = substr($name, 6);
      }
      if (empty($name)) {
        throw new InvalidArgumentException(
          'Unable to install theme, empty directory name."'
        );
      }
      return $this->getDocumentRoot().'papaya-themes/'.$name;
    }

    public function supports($packageType) {
      return 'papaya-theme' === $packageType;
    }
  }
}
