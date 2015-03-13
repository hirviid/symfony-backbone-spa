<?php
/**
 * User: david.vangompel@calibrate.be
 * Date: 06/03/15
 * Time: 21:51
 */

namespace Ui\SharedBundle\Request;


use CoreDomain\TimeSlot\Commands\TrackTimeCommand;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrackTimeRequest
{
    private $options;

    /**
     * @param array $options
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     */
    public function __construct(array $options = array())
    {
        $resolver = new OptionsResolver();

        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);
    }

    public function getData()
    {
        $command = new TrackTimeCommand();
        $command->description = $this->options['description'];
        $command->startedAt = $this->options['startedAt'];
        $command->stoppedAt = $this->options['stoppedAt'];
        return $command;
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
//        $resolver->setDefaults(array(
//                'startedAt' => null,
//                'stoppedAt' => null
//            ));

        $resolver->setRequired(array(
                'startedAt',
                'stoppedAt',
                'description'
            ));

        $resolver->setAllowedTypes(array(
                'description' => array('string'),
                'startedAt' => array('string'),
                'stoppedAt' => array('string')
            ));

        /*$resolver->setNormalizer('startedAt', function ($options, $value) {
                if (!$value instanceof \DateTime) {
                    $value = new \DateTime($value);
                }
                return $value;
            });

        $resolver->setNormalizer('stoppedAt', function ($options, $value) {
                if (!$value instanceof \DateTime) {
                    $value = new \DateTime($value);
                }
                return $value;
            });*/
    }
} 