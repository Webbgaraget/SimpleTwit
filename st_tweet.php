<?php
/**
 * Description of st-tweet
 *
 * @author George Yates
 */
require_once 'lib/tmhUtilities.php';

class ST_Tweet {
	private $wp_post;
	private $wp_id;

	public $is_retweet;
	public $is_response;
	public $content;
	public $time;
	public $time_gmt;
	public $time_str;

	function __construct($id = 0) {
		$this->wp_id = $id;

		$this->wp_post = get_post($this->wp_id);

		$this->is_retweet = get_post_meta($this->wp_id, 'is_retweet', true) == 1;
		$this->is_response = get_post_meta($this->wp_id, 'is_reply', true) == 1;

		$this->content = $this->wp_post->post_content;
		$this->time = $this->wp_post->post_date;
		$this->time_gmt = $this->wp_post->post_date_gmt;
		$this->time_str = $this->get_default_time_str();
	}

	private function get_default_time_str() {
		$tz = new DateTimeZone(get_option('timezone_string', 'GMT'));
		$time = new DateTime();
		$time = setTimestamp($this->time_gmt);
		$time = $time->setTimezone($tz);
		return parseTwitterDate($time->format('Y-m-d H:i:s'));
	}

	
}
?>
