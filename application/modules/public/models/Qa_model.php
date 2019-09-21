<?php
class Qa_model extends CI_Model
{
	/**
	 * number of result objects
	 *
	 * some functions like all() set this variable and
	 * it should be called after such functions execute.
	 *
	 * @var int
	 **/
	public $count = 0;

	/**
	 * error message set by functions
	 *
	 * @var string
	 **/
	public $error_message = '';

	/**
	 * id of user object
	 *
	 * some functions like add() set this variable and
	 * it should be called after such functions execute.
	 *
	 * @var int
	 **/
	public $id = 0;

	/**
	 * Set any error that occurs
	 *
	 * @var	string $message error meassage to be set
	 **/
	public function set_error_message($message = '')
	{
		$this->error_message = $message;
	}

	/**
	 * Return error message
	 *
	 * @return string
	 **/
	public function error_message()
	{
		return $this->error_message;
	}

	// count types.
	public function count()
	{
		return $this->db->from('questions')->count_all_results();
	}

	public function __construct()
	{
		$this->load->database();
	}

	public function get_questions($options = array())
	{
		// $q = $this->db->query(
		// 	'SELECT id, title, answersCount, votesCount
		// 	FROM questions
		// 	LEFT JOIN
		// 	(
		// 		SELECT question_id, COUNT(*) answersCount, votesCount
		// 		FROM questions_answers
		// 		LEFT JOIN
		// 		(
		// 			SELECT answer_id, COUNT(*) votesCount  
		// 			FROM question_answers_votes
		// 			GROUP BY answer_id
		// 		) inner_1
		// 		ON
		// 	 	inner_1.answer_id = questions_answers.id
		// 		GROUP BY question_id
		// 	) inner_2
		// 	ON
		// 	inner_2.question_id = questions.id'
		// )->result();

		// var_dump($q); exit();

		if (isset($options['id'])) $this->db->where('id', $id);
		if (isset($options['user_id'])) $this->db->where('user_id', $user_id);
		if (isset($options['spec'])) $this->db->where('speciality', $spec);

		if (isset($options['time_elapsed']))
		{
			if ($options['time_elapsed'] === 'week')
			{
				$this->db->where('created_on >= DATE_SUB(NOW(), INTERVAL 1 WEEK)');
			}
			if ($options['time_elapsed'] === 'month')
			{
				$this->db->where('created_on >= DATE_SUB(NOW(), INTERVAL 1 MONTH)');
			}
		}

		if (isset($options['limit']))
		{
			// Limit the number of results and also get results from
			// a specific starting point - used when paginating results.
			$this->db->limit($options['limit'], $options['start']);
		}
		
		$this->db->select('questions.id, questions.user_id, questions.slug, questions.title, questions.created_on');

		if (isset($options['count']))
		{
			return $this->db->count_all_results('questions');	
		}

		$this->db->from('questions');

		// Get and Join the answers count and the  votes count
		$this->db->select('IFNULL(answersCount, 0) answersCount');
		$this->db->select('IFNULL(votesCount, 0) votesCount');
		$this->db->join(
			'(
				SELECT question_id, COUNT(*) answersCount, votesCount
				FROM questions_answers
				LEFT JOIN
				(
					SELECT answer_id, COUNT(*) votesCount  
					FROM question_answers_votes
					GROUP BY answer_id
				) inner_1
				ON
			 	inner_1.answer_id = questions_answers.id
				GROUP BY question_id
			) inner_2', 'inner_2.question_id = questions.id', 'left');
		
		// Get and Join the answers count and the  votes count
		$this->db->select('doctor_specialities.name AS speciality');
		$this->db->join('doctor_specialities', 'doctor_specialities.id = questions.speciality_id', 'left');

		$q = $this->db->get()->result();
		
		if ( ! empty($q))
		{
			foreach ($q as $row)
			{
				$row->time_elapsed = $this->time_elapsed_string($row->created_on);
			}
		}
		return $q;
	}

	public function get_unanswered($options = array())
	{
		$this->db->select('questions.id, questions.title, questions.slug');
		$this->db->from('questions');
		$this->db->where('answersCount', null);

		if ($options['limit']) $this->db->limit($options['limit']);

		$this->db->join('
			(
				SELECT question_id, COUNT(*) answersCount
				FROM questions_answers
				GROUP BY question_id
			) inner_2', 'inner_2.question_id = questions.id', 'left');

		return $this->db->get()->result();
	}

	public function get_question($slug)
	{
		$this->db->limit(1);
		$this->db->where('slug', $slug);
		$q = $this->db->get('questions')->result();
		
		if ( ! empty($q))
		{
			foreach ($q as $row)
			{
				$row->time_elapsed = $this->time_elapsed_string($row->created_on);

				$this->db->limit(1);
				$speciality  = $this->db->get_where('doctor_specialities', array(
					'id' => $row->speciality
				))->result();

				if ( ! empty($speciality))
				{
					$row->speciality = $speciality[0]->name;
				}

				$this->load->model('users/user');
				$row->asker = $this->user->details($row->user_id);
				$row->answers = $this->get_answers(array('question_id' => $row->id));
			}
		}
		return $q[0];
	}

	public function answer_question($id)
	{
		$insert['user_id'] = $this->input->post('user_id');
		$insert['question_id'] = $id;

		$answers = $this->db->count_all('questions_answers', $insert);

		if ($answers < 1) {
			$insert['answer'] = $this->input->post('answer');

			$this->db->insert('questions_answers', $insert);

			if ($this->db->affected_rows()) {
				return true;
			} else {
				$this->set_error_message('Answer could not be posted.');
				return false;
			}
		} else {
			$this->set_error_message('You have already answered this question.');
			return false;
		}
	}

	public function add_question($user_id)
	{
		$insert['user_id'] = $user_id;
		$insert['title'] = $this->input->post('title');
		$insert['slug'] = url_title($this->input->post('title'));
		$insert['speciality'] = url_title($this->input->post('speciality'));
		$insert['question'] = $this->input->post('question');

		$this->db->insert('questions', $insert);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			// Remove the uploaded image.
			if ( isset($insert['image']) ) {
				unlink($this->app['file_path'].$insert['image']);
			}

			$this->set_error_message('Question could not be posted.');
			return false;
		}
	}

	public function get_answers($options = array())
	{
		if (isset($options['question_id']))
		{
			$this->db->where('question_id', $options['question_id']);
		}
		
		$q = $this->db->get('questions_answers')->result();
		
		if ( ! empty($q))
		{
			foreach ($q as $row)
			{
								$this->db->where('answer_id', $row->id);
								$this->db->where('liked', 1);
				$row->u_votes = $this->db->count_all_results('question_answers_votes');

								$this->db->where('answer_id', $row->id);
								$this->db->where('liked', 0);
				$row->d_votes = $this->db->count_all_results('question_answers_votes');

				$row->time_elapsed = $this->time_elapsed_string($row->created_on);

				$this->load->model('users/user');
				$row->user = $this->user->details($row->user_id);
			}
		}

		return $q;
	}

	public function vote_answer($id)
	{
		$this->db->where('user_id', $this->input->post('user_id'));
		$this->db->where('answer_id', $id);

		$answers = $this->db->count_all_results('question_answers_votes');

		if ($answers < 1)
		{
			$insert['user_id'] = $this->input->post('user_id');
			$insert['answer_id'] = $id;
			$insert['liked'] = (bool) $this->input->post('vote');

			$this->db->insert('question_answers_votes', $insert);

			if ($this->db->affected_rows())
			{
				return array(
					'error' => false,
					'alert' => array(
						'type' 	  => 'success',
						'message' => 'Vote has been recorded.'
					)
				);
			}
			else
			{
				return array(
					'error' => true,
					'alert' => array(
						'type' 	  => 'danger',
						'message' => 'Vote could not be recorded.'
					)
				);
			}
		}
		else
		{
			$this->db->where('user_id', $this->input->post('user_id'));
			$this->db->where('answer_id', $id);
			$insert['user_id'] = $this->input->post('user_id');
			$insert['answer_id'] = $id;
			$insert['liked'] = (bool) $this->input->post('vote');
			$this->db->update('question_answers_votes', $insert);

			if ($this->db->affected_rows())
			{
				return array(
					'error' => false,
					'alert' => array(
						'type' 	  => 'success',
						'message' => 'Vote has been recorded.'
					)
				);
			}
			else
			{
				return array(
					'error' => true,
					'alert' => array(
						'type' 	  => 'danger',
						'message' => 'Vote could not be recorded.'
					)
				);
			}
		}
	}

	private function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
			);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
}
