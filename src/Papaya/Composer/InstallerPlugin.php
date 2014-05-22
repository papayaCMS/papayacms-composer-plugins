<?php

namespace Papaya\Composer {

  use Composer\Composer;
  use Composer\IO\IOInterface;
  use Composer\Plugin\PluginInterface;

  class InstallerPlugin implements PluginInterface {

    public function activate(Composer $composer, IOInterface $io) {
      $extras = $composer->getPackage()->getExtra();
      $documentRoot = NULL;
      $templateDirectory = NULL;
      if (isset($extras['document-root'])) {
        $documentRoot = $extras['document-root'];
      }
      if (isset($extras['papaya']['template-directory'])) {
        $templateDirectory = $extras['papaya']['template-directory'];
      }
      $installers = array(
        new TemplateInstaller($io, $composer),
        new ThemeInstaller($io, $composer),
        new AdministrationInstaller($io, $composer)
      );
      foreach ($installers as $installer) {
        $installer->setDocumentRoot($documentRoot);
        $installer->setTemplateDirectory($templateDirectory);
        $composer->getInstallationManager()->addInstaller(
          $installer
        );
      }
    }
  }
}