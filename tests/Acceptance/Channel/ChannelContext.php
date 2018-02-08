<?php

declare(strict_types=1);

namespace Pim\Acceptance\Channel;

use Behat\Behat\Tester\Exception\PendingException;
use Pim\Acceptance\Currency\InMemoryCurrencyRepository;
use Behat\Behat\Context\Context as BehatContext;
use Pim\Acceptance\Category\InMemoryCategoryRepository;
use Pim\Acceptance\Locale\InMemoryLocaleRepository;
use Pim\Acceptance\ResourceBuilder;

class ChannelContext implements BehatContext
{
    protected $localeRepository;
    protected $channelRepository;
    /**
     * @var InMemoryCategoryRepository
     */
    private $categoryRepository;
    /**
     * @var ChannelBuilder
     */
    private $channelBuilder;
    /** @var ResourceBuilder */
    private $categoryBuilder;
    /** @var ResourceBuilder */
    private $currencyRepository;
    /** @var ResourceBuilder */
    private $currencyBuilder;

    public function __construct(
        InMemoryLocaleRepository $localeRepository,
        InMemoryCategoryRepository $categoryRepository,
        InMemoryChannelRepository $channelRepository,
        InMemoryCurrencyRepository $currencyRepository,
        ResourceBuilder $categoryBuilder,
        ResourceBuilder $channelBuilder,
        ResourceBuilder $currencyBuilder
    ) {
        $this->localeRepository = $localeRepository;
        $this->channelRepository = $channelRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categoryBuilder = $categoryBuilder;
        $this->channelBuilder = $channelBuilder;
        $this->currencyRepository = $currencyRepository;
        $this->currencyBuilder = $currencyBuilder;
    }

    /**
     * @Given /^the following "([^"]*)" channel with locales? "([^"]*)"$/
     */
    public function theFollowingChannel(string $channelCode, string $localeCodes)
    {
        $masterCategory = $this->categoryBuilder->build(['code' => 'master']);
        $this->categoryRepository->save($masterCategory);

        $currency = $this->currencyBuilder->build(['code' => 'EUR']);
        $this->currencyRepository->save($currency);

        $channelData = [
            'code' => $channelCode,
            'locales' => explode(',', $localeCodes),
            'category_tree' => 'master',
            'currencies' => ['EUR']
        ];

        $channel = $this->channelBuilder->build($channelData);
        $this->channelRepository->save($channel);
    }

    /**
     * @Then /^I remove the locale "([^"]*)" from the "([^"]*)" channel$/
     */
    public function iRemoveTheLocaleFromTheChannel(string $localeCode, string $channelCode)
    {
        $channel = $this->channelRepository->findOneByIdentifier($channelCode);
        if (null === $channel) {
            throw new \Exception(sprintf('Channel "%s" not found', $channelCode));
        }

        $locale = $this->localeRepository->findOneByIdentifier($localeCode);
        if (null === $locale) {
            throw new \Exception(sprintf('Locale "%s" not found', $localeCode));
        }

        $channel->removeLocale($locale);
        $this->channelRepository->save($channel);
    }

    /**
     * @When I add the locale :localeCode from the :channelCode channel
     */
    public function iAddTheLocaleFromTheChannel($localeCode, $channelCode)
    {
        $channel = $this->channelRepository->findOneByIdentifier($channelCode);
        $locale = $this->localeRepository->findOneByIdentifier($localeCode);

        $channel->addLocale($locale);

        $this->channelRepository->save($channel);
    }
}