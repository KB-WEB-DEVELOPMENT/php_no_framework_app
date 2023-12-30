<?php 
declare(strict_types=1);

namespace SocialNews\FrontPage\Infrastructure;

use Doctrine\DBAL\Connection;
use SocialNews\FrontPage\Application\Submission;
use SocialNews\FrontPage\Application\SubmissionsQuery;

final class DbalSubmissionsQuery implements SubmissionsQuery
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    // missing stuff - just the general idea

    /*
    $qb->addSelect('submissions.title');
    $qb->addSelect('submissions.url');
    $qb->addSelect('authors.nickname');
    $qb->from('submissions');
    $qb->join(
            'submissions',
            'users',
            'authors',
            'submissions.author_user_id = authors.id'
    );
    $qb->orderBy('submissions.creation_date', 'DESC');

    $submissions[] = new Submission($row['url'], $row['title'], $row['nickname']);
    
    */
}    
