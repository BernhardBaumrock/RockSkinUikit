<?php namespace ProcessWire;
/**
 * RockSkinUikit
 *
 * @author Bernhard Baumrock, 13.01.2019
 * @license Licensed under MIT
 * @link https://www.baumrock.com
 */
class RockSkinUikit extends WireData implements Module {

  public static function getModuleInfo() {
    return [
      'title' => 'RockSkinUikit',
      'version' => '0.0.1',
      'summary' => 'Helper module to easily skin the Uikit Admin Theme',
      'autoload' => true,
      'icon' => 'paint-brush',
      'requires' => ['RockLESS'],
      'installs' => [],
    ];
  }

  public function init() {
    // hook to monitor the admin theme less file
    $this->addHookAfter('AdminThemeUikit::getUikitCSS', $this, 'monitorAdminUikitLessFile');
  }
  
  /**
   * If AdminThemeUikit has set a LESS file monitor it for changes.
   *
   * @param HookEvent $event
   * @return void
   */
  public function monitorAdminUikitLessFile($event) {
    $file = $this->config->paths->root . trim($event->return, '/');
    if(!is_file($file)) return;

    $info = pathinfo($file);
    if(!$info['extension'] == 'less') return;

    // load less module
    $less = $this->modules->get('RockLESS');
    $newfile = "$file.css";
    $less->getCSS($file, $newfile, null, null, $this->files->find(__DIR__, ['extensions'=>['less']]));

    $t = filemtime($newfile);
    $event->return = $less->getUrl($newfile) . "?t=$t";
  }

  /**
   * Download and install raw AdminThemeUikit source files
   *
   * @return void
   */
  public function ___install() {
    $url = "https://github.com/BernhardBaumrock/AdminThemeUikit/archive/master.zip";

    require_once($this->config->paths->modules . "Process/ProcessModule/ProcessModuleInstall.php");
    $install = $this->wire(new ProcessModuleInstall());
    $install->downloadModule($url);
    $this->modules->install("AdminThemeUikit");
    $this->modules->duplicates()->setUseDuplicate("AdminThemeUikit", "/site/modules/AdminThemeUikit/AdminThemeUikit.module");
    $this->modules->refresh();

    // copy theme to assets folder
    $path = $this->config->paths->assets . $this->className;
    $this->files->copy(__DIR__ . "/assets", $path);

    $module = $this->modules->get("AdminThemeUikit");
    $config = $this->modules->getModuleConfigData($module);
    $config['cssURL'] = "/site/assets/RockSkinUikit/theme.less";
    $config['logoURL'] = "/site/assets/RockSkinUikit/processwire.svg";
    $this->modules->saveConfig($module, $config);
  }

  /**
   * Reset css and logo url on uninstall.
   *
   * @return void
   */
  public function ___uninstall() {
    $module = $this->modules->get("AdminThemeUikit");
    $config = $this->modules->getModuleConfigData($module);
    $config['cssURL'] = "";
    $config['logoURL'] = "";
    $this->modules->saveConfig($module, $config);
  }

}