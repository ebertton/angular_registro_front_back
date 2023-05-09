<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications;

use Imdhemy\GooglePlay\DeveloperNotifications\Builders\DeveloperNotificationBuilder;
use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\Arrayable;
use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;
use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\RealTimeDeveloperNotification;
use Imdhemy\GooglePlay\ValueObjects\Time;
use JsonException;
use RuntimeException;

/**
 * Class DeveloperNotification
 * This class represents the Real-time developer notifications from Google
 * {@link https://developer.android.com/google/play/billing/rtdn-reference}.
 */
class DeveloperNotification implements RealTimeDeveloperNotification, Arrayable
{
    /**
     * The version of this notification.
     * Initially, this is "1.0". This version is distinct from other version fields.
     *
     * @var string
     */
    protected string $version;

    /**
     * The package name of the application that this notification relates to
     * (for example, `com.some.thing`).
     *
     * @var string
     */
    protected string $packageName;

    /**
     * The timestamp when the event occurred, in milliseconds since the Epoch.
     *
     * @var int
     */
    protected int $eventTimeMillis;

    /**
     * @var NotificationPayload
     */
    private NotificationPayload $payload;

    /**
     * @var array
     */
    private array $decodedData;

    /**
     * @param DeveloperNotificationBuilder $builder
     */
    public function __construct(DeveloperNotificationBuilder $builder)
    {
        $this->version = $builder->getVersion();
        $this->packageName = $builder->getPackageName();
        $this->eventTimeMillis = $builder->getEventTimeMillis();
        $this->payload = $builder->getPayload();
        $this->decodedData = $builder->getDecodedData();
    }

    /**
     * Parses the notification data into a developer notification
     *
     * @param string $data
     *
     * @return DeveloperNotification
     */
    public static function parse(string $data): DeveloperNotification
    {
        try {
            $decodedData = json_decode(base64_decode($data), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RuntimeException('Invalid notification data');
        }

        return DeveloperNotificationBuilder::init()
            ->setDecodedData($decodedData)
            ->setVersion($decodedData['version'])
            ->setPackageName($decodedData['packageName'])
            ->setEventTimeMillis($decodedData['eventTimeMillis'])
            ->setPayloadFromArray($decodedData)
            ->build();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->payload->getType();
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getPackageName(): string
    {
        return $this->packageName;
    }

    /**
     * @return Time
     */
    public function getEventTime(): Time
    {
        return new Time($this->eventTimeMillis);
    }

    /**
     * @return int
     */
    public function getEventTimeMillis(): int
    {
        return $this->eventTimeMillis;
    }

    /**
     * @return NotificationPayload|OneTimePurchaseNotification|SubscriptionNotification|TestNotification
     */
    public function getPayload(): NotificationPayload
    {
        return $this->payload;
    }

    /**
     * @return bool
     */
    public function isTestNotification(): bool
    {
        return $this->payload instanceof TestNotification;
    }

    /**
     * Return the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->decodedData;
    }
}
