<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WarehouseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $products;
    private $details;

    /**
     * Create a new notification instance.
     *
     * @param $details
     * @param $products
     */
    public function __construct($details, $products)
    {
        $this->details = $details;
        $this->products = $products;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->line('New order')
            ->line('Visitor email: ' . $this->details['email'])
            ->line(
                'Address: '
                . $this->details['shipping_address_1']
                . $this->details['shipping_address_2']
                . $this->details['shipping_address_3']
                . ','
                . $this->details['city']
                . ','
                . $this->details['country_code']
                . ','
                . $this->details['zip_postal_code']
            )
            ->line($this->products);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [//
        ];
    }
}
