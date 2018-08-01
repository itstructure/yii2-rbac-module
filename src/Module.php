<?php

namespace Itstructure\RbacModule;

use Yii;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\rbac\ManagerInterface;
use yii\base\{Module as BaseModule, InvalidConfigException};
use Itstructure\RbacModule\components\{RbacValidateComponent, ProfileValidateComponent};

/**
 * Rbac module class.
 *
 * @property null|string|array $loginUrl
 * @property array $accessRoles
 * @property View $_view
 * @property ManagerInterface $_authManager
 *
 * @package Itstructure\RbacModule
 */
class Module extends BaseModule
{
    /**
     * Login url.
     *
     * @var null|string|array
     */
    public $loginUrl = null;

    /**
     * Array of roles to module access.
     *
     * @var array
     */
    public $accessRoles = ['@'];

    /**
     * View component to render content.
     *
     * @var View
     */
    private $_view = null;

    /**
     * Auth manager.
     *
     * @var ManagerInterface
     */
    private $_authManager;

    /**
     * Module translations.
     *
     * @var array|null
     */
    private static $_translations = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->_authManager = Yii::$app->authManager;

        if (null === $this->_authManager){
            throw new InvalidConfigException('The authManager is not defined.');
        }

        if (!$this->_authManager instanceof ManagerInterface){
            throw new InvalidConfigException('The authManager must be implemented from yii\rbac\ManagerInterface.');
        }

        Yii::setAlias('@rbac', static::getBaseDir());

        if (null !== $this->loginUrl && method_exists(Yii::$app, 'getUser')) {
            Yii::$app->getUser()->loginUrl = $this->loginUrl;
        }

        self::registerTranslations();

        /**
         * Set Rbac validate component
         */
        $this->setComponents(
            ArrayHelper::merge(
                $this->getRbacValidateComponentConfig(),
                $this->components
            )
        );

        /**
         * Set Profile validate component
         */
        $this->setComponents(
            ArrayHelper::merge(
                $this->getProfileValidateComponentConfig(),
                $this->components
            )
        );
    }

    /**
     * Get the view.
     *
     * @return View
     */
    public function getView()
    {
        if (null === $this->_view) {
            $this->_view = $this->get('view');
        }

        return $this->_view;
    }

    /**
     * Returns module root directory.
     *
     * @return string
     */
    public static function getBaseDir(): string
    {
        return __DIR__;
    }

    /**
     * Module translator.
     *
     * @param       $category
     * @param       $message
     * @param array $params
     * @param null  $language
     *
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        if (null === self::$_translations){
            self::registerTranslations();
        }

        return Yii::t('modules/rbac/' . $category, $message, $params, $language);
    }

    /**
     * Set i18N component.
     *
     * @return void
     */
    private function registerTranslations(): void
    {
        self::$_translations = [
            'modules/rbac/*' => [
                'class'          => 'yii\i18n\PhpMessageSource',
                'forceTranslation' => true,
                'sourceLanguage' => Yii::$app->language,
                'basePath'       => '@rbac/messages',
                'fileMap'        => [
                    'modules/rbac/main' => 'main.php',
                    'modules/rbac/roles' => 'roles.php',
                    'modules/rbac/permissions' => 'permissions.php',
                    'modules/rbac/profiles' => 'profiles.php',
                    'modules/rbac/rbac' => 'rbac.php',
                ],
            ]
        ];

        Yii::$app->i18n->translations = ArrayHelper::merge(
            self::$_translations,
            Yii::$app->i18n->translations
        );
    }

    /**
     * Rbac validate component config.
     *
     * @return array
     */
    private function getRbacValidateComponentConfig(): array
    {
        return [
            'rbac-validate-component' => [
                'class' => RbacValidateComponent::class,
                'authManager' => $this->_authManager,
            ]
        ];
    }

    /**
     * Profile validate component config.
     *
     * @return array
     */
    private function getProfileValidateComponentConfig(): array
    {
        return [
            'profile-validate-component' => [
                'class' => ProfileValidateComponent::class,
                'authManager' => $this->_authManager,
            ]
        ];
    }
}
