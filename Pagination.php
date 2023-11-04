<?php
/**
 * Pagination
 * @author Gökhan Kaya <gkxdev@gmail.com>
 */

class Pagination {
    const QUERY_STRING = 'page';

    private $total, $limit, $url;
    private $pages, $page;

    public function __construct($total, $limit = 10, $url = '') {
        $this->total = $total;
        $this->limit = $limit;
        $this->url   = $url;

        $this->pages = ceil($total / $limit);

        $this->page = min(
            max((int) @$_GET[self::QUERY_STRING], 1),
            $this->pages
        );
    }

    public function limit() {
        return $this->limit;
    }

    public function offset() {
        return ($this->page - 1) * $this->limit;
    }

    public function html() {
        $prev = $next = null;

        if ($this->page > 1) {
            $prev = $this->makeLink($this->page - 1, '&larr; Geri');
        }

        if ($this->page < $this->pages) {
            $next = $this->makeLink($this->page + 1, 'İleri &rarr;');
        }

        $info = sprintf('<span class="pagination-info">%d / %d</span>',
            $this->page,
            $this->pages
        );

        return sprintf('<div class="pagination">%s%s%s</div>',
            $prev, $info, $next
        );
    }

    private function makeLink($number, $text) {
        $qs = (bool) strpos($this->url, '?')
            ? '&'
            : '?';

        return sprintf('<a class="pagination-item" href="%s=%d">%s</a>',
            $this->url . $qs . self::QUERY_STRING,
            $number,
            $text
        );
    }
}