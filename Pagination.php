<?php
/**
 * Pagination
 * @author Gökhan Kaya <gkxdev@gmail.com>
 */

class Pagination {
    const QUERY_STRING = 'page';

    private $total, $limit, $url;
    private $pages, $page;

    public function __construct(int $total, int $limit = 10, $url = '') {
        $this->total = $total;
        $this->limit = $limit;
        $this->url   = url($url);

        if ($this->total == 0) $this->total = 1;

        $this->pages = ceil($this->total / $this->limit);

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
        // if ($this->pages == 1) return;

        $prevNumber = $this->page > 1
            ? ($this->page - 1)
            : 1;

        $nextNumber = $this->page < $this->pages
            ? ($this->page + 1)
            : $this->pages;

        $prevUrl      = $this->getUrl($prevNumber);
        $prevDisabled = $this->page <= 1 ? 'disabled' : '';

        $nextUrl      = $this->getUrl($nextNumber);
        $nextDisabled = $this->page >= $this->pages ? 'disabled' : '';

        return <<<HTML
        <nav>
            <ul class="pagination justify-content-center my-3">
                <li class="page-item">
                    <a class="page-link {$prevDisabled}" href="{$prevUrl}">&larr;</a>
                </li>
                 <li class="page-item">
                    <a class="page-link disabled" href="javascript:;">{$this->page} / {$this->pages}</a>
                </li>
                <li class="page-item">
                    <a class="page-link {$nextDisabled}" href="{$nextUrl}">&rarr;</a>
                </li>
            </ul>
        </nav>
        HTML;
    }

    private function getUrl(int $number) {
        $qs = (bool) strpos($this->url, '?')
            ? '&'
            : '?';

        return sprintf('%s%s=%d',
            $this->url,
            ($qs . self::QUERY_STRING),
            $number
        );
    }
}
