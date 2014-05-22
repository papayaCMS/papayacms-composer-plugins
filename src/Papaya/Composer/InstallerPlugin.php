<?php

namespace Papaya\Composer {

  use Composer\Composer;
  use Composer\IO\IOInterface;
  use Composer\Plugin\PluginInterface;

  class InstallerPlugin implements PluginInterface {

    public function activate(Composer $composer, IOInterface $io) {
      $extras = $composer->getPackage()->getExtra();
      if (isset($extras['document-root'])) {
        $documentRoot = $extras['document-root'];
      } else {
        $documentRoot = 'htdocs/';
      }
      $installers = array(
        new TemplateInstaller($io, $composer),
        new ThemeInstaller($io, $composer),
        new AdministrationInstaller($io, $composer)
      );
      foreach ($installers as $installer) {
        $installer->setDocumentRoot($documentRoot);
        $composer->getInstallationManager()->addInstaller(
          $installer
        );
      }
    }
  }
}