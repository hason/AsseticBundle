<?php

/*
 * This file is part of the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Symfony\Bundle\AsseticBundle\Asset;

use Assetic\Asset\AssetInterface;
use Assetic\Factory\LazyAssetManager;
use Assetic\Filter\FilterInterface;

/**
 * @author Martin Hasoň <martin.hason@gmail.com>
 */
class ChildrenModifiedAsset implements AssetInterface
{
    private $asset;
    private $am;

    public function __construct(AssetInterface $asset, LazyAssetManager $am)
    {
        $this->asset = $asset;
        $this->am = $am;
    }

    public function ensureFilter(FilterInterface $filter)
    {
        $this->asset->ensureFilter($filter);
    }

    public function getFilters()
    {
        return $this->asset->getFilters();
    }

    public function clearFilters()
    {
        $this->asset->clearFilters();
    }

    public function load(FilterInterface $additionalFilter = null)
    {
        $this->asset->load($additionalFilter);
    }

    public function dump(FilterInterface $additionalFilter = null)
    {
        return $this->asset->dump($additionalFilter);
    }

    public function getContent()
    {
        return $this->asset->getContent();
    }

    public function setContent($content)
    {
        $this->asset->setContent($content);
    }

    public function getSourceRoot()
    {
        return $this->asset->getSourceRoot();
    }

    public function getSourcePath()
    {
        return $this->asset->getSourcePath();
    }

    public function getSourceDirectory()
    {
        return $this->asset->getSourceDirectory();
    }

    public function getTargetPath()
    {
        return $this->asset->getTargetPath();
    }

    public function setTargetPath($targetPath)
    {
        $this->asset->setTargetPath($targetPath);
    }

    public function getLastModified()
    {
        if (null !== $lastModified = $this->am->getLastModified($this->asset)) {
            return $lastModified;
        }

        return $this->asset->getLastModified();
    }

    public function getVars()
    {
        return $this->asset->getVars();
    }

    public function setValues(array $values)
    {
        $this->asset->setValues($values);
    }

    public function getValues()
    {
        return $this->asset->getValues();
    }

    public function __call($method, $arguments)
    {
        if (method_exists($this->asset, $method)) {
            return call_user_func_array(array($this->asset, $method), $arguments);
        }

        throw new \BadMethodCallException(sprintf('Method "%s::%s()" does not exist.', get_class($this->asset), $method));
    }
}

