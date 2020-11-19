<?php

namespace Papaya\Composer {

  use Composer\Installer\LibraryInstaller;
  use Composer\Package\PackageInterface;
  use Composer\Repository\InstalledRepositoryInterface;
    use InvalidArgumentException;

    abstract class PapayaInstaller extends LibraryInstaller {

    private $_documentRoot = '';
    private $_templateDirectory = '';

    public function setDocumentRoot($path) {
      $this->_documentRoot = 'htdocs/';
      $path = trim($path);
      if (!empty($path)) {
        $trailingChar = substr($path, -1);
        if ($trailingChar !== DIRECTORY_SEPARATOR && $trailingChar !== '/') {
          $this->_documentRoot = $path.'/';
        } else {
          $this->_documentRoot = $path;
        }
      }
    }

    public function getDocumentRoot() {
      return $this->_documentRoot;
    }

    public function setTemplateDirectory($path) {
      $this->_templateDirectory = 'templates/';
      $path = trim($path);
      if (!empty($path)) {
        $trailingChar = substr($path, -1);
        if ($trailingChar !== DIRECTORY_SEPARATOR && $trailingChar !== '/') {
          $this->_templateDirectory = $path.'/';
        } else {
          $this->_templateDirectory = $path;
        }
      }
    }

    public function getTemplateDirectory() {
      return $this->_templateDirectory;
    }

    public function uninstall(
      InstalledRepositoryInterface $repo, PackageInterface $package
    ) {
      if (!$repo->hasPackage($package)) {
        throw new InvalidArgumentException('Package is not installed: '.$package);
      }

      $repo->removePackage($package);

      $installPath = $this->getInstallPath($package);
      $this->io->write(
        sprintf(
          'Deleting %s - %s',
          $installPath,
          $this->filesystem->removeDirectory($installPath)
            ? '<comment>deleted</comment>' : '<error>not deleted</error>'
        )
      );
    }
  }
}
