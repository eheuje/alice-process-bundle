<?php


namespace Jycamier\AliceProcessBundle\Task\File;

use CleverAge\ProcessBundle\Model\ProcessState;
use CleverAge\ProcessBundle\Task\AbstractIterableOutputTask;
use Faker\Generator;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AliceFixtureLoaderTask extends AbstractIterableOutputTask
{
    /**
     * @var Generator
     */
    private $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @inheritDoc
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(
            [
                'file_path',
            ]
        );
        $resolver->setAllowedTypes('file_path', ['string']);
        $resolver->setNormalizer(
            'file_path',
            static function (Options $options, $value) {
                if (!file_exists($value)) {
                    throw new \UnexpectedValueException("File not found: {$value}");
                }
                return $value;
            }
        );
    }

    /**
     * @inheritDoc
     * @throws \Symfony\Component\OptionsResolver\Exception\ExceptionInterface
     */
    protected function initializeIterator(ProcessState $state): \Iterator
    {
        $filePath = $this->getOption($state, 'file_path');

        $loader = new NativeLoader($this->generator);
        $objectSet = $loader->loadFile($filePath);

        $objects =$objectSet->getObjects();

        if (!\is_array($objects)) {
            throw new \InvalidArgumentException("File content is not an array: {$filePath}");
        }
        return new \ArrayIterator($objects);
    }
}
