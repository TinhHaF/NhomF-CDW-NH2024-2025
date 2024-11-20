<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Post;

class NewPostNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private Post $post;

    /**
     * Tạo một instance mới cho notification.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Các kênh thông báo sẽ được sử dụng.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // Chỉ sử dụng mail để gửi thông báo
    }

    /**
     * Tạo nội dung email cho notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Tạo URL của bài viết
        $url = url('/homepage/posts/' . $this->post->id . '-' . $this->post->slug);

        // Tạo nội dung email
        return (new MailMessage)
            ->subject('Bài viết mới: ' . $this->post->title) // Tiêu đề email
            ->line('Một bài viết mới đã được đăng trên trang của chúng tôi.') // Nội dung chính
            ->line('Tiêu đề: ' . $this->post->title) // Tiêu đề bài viết
            ->action('Xem bài viết', $url) // Nút liên kết đến bài viết
            ->line('Cảm ơn bạn đã đăng ký nhận tin từ chúng tôi!'); // Lời cảm ơn
    }
}
