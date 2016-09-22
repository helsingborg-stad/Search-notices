<?php

namespace SearchNotices;

class App
{
    public function __construct()
    {
        add_action('init', array($this, 'init'));
        add_action('wp', array($this, 'output'));
    }

    public function init()
    {
        $this->fields();
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page(array(
                'page_title' => __('Search notices', 'search-notices'),
                'menu_title' => __('Search notices', 'search-notices'),
                'menu_slug'  => 'search-notices',
                'capability' => 'edit_posts',
                'position'   => 500,
                'icon_url'   => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+Cjxzdmcgd2lkdGg9IjM3NnB4IiBoZWlnaHQ9IjM3NnB4IiB2aWV3Qm94PSIwIDAgMzc2IDM3NiIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4KICAgIDwhLS0gR2VuZXJhdG9yOiBTa2V0Y2ggMzkuMSAoMzE3MjApIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPgogICAgPHRpdGxlPm5vdW5fNTAwOTQ0X2NjPC90aXRsZT4KICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPgogICAgPGRlZnM+PC9kZWZzPgogICAgPGcgaWQ9IlBhZ2UtMSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPGcgaWQ9Im5vdW5fNTAwOTQ0X2NjIiBmaWxsPSIjMDAwMDAwIj4KICAgICAgICAgICAgPGcgaWQ9Ikdyb3VwIj4KICAgICAgICAgICAgICAgIDxyZWN0IGlkPSJSZWN0YW5nbGUtcGF0aCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTUwLjU3NTQ2MCwgMTIyLjQzNjUzNCkgcm90YXRlKDI2OS45OTU1NTgpIHRyYW5zbGF0ZSgtMTUwLjU3NTQ2MCwgLTEyMi40MzY1MzQpICIgeD0iMTAyLjc3NTQ2IiB5PSIxMDMuNjg2NTM0IiB3aWR0aD0iOTUuNiIgaGVpZ2h0PSIzNy41Ij48L3JlY3Q+CiAgICAgICAgICAgICAgICA8cmVjdCBpZD0iUmVjdGFuZ2xlLXBhdGgiIHg9IjEzMS44IiB5PSIxODgiIHdpZHRoPSIzNy41IiBoZWlnaHQ9IjM3LjUiPjwvcmVjdD4KICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0zNjEuOCwyOTUuNSBMMjg0LjQsMjE4LjEgQzMxMi44LDE2MS44IDMwMy42LDkxLjUgMjU2LjYsNDQuNSBDMTk4LC0xNC4xIDEwMy4xLC0xNC4xIDQ0LjUsNDQuNSBDLTE0LjEsMTAzLjEgLTE0LjEsMTk4IDQ0LjUsMjU2LjYgQzkxLjUsMzAzLjYgMTYxLjksMzEyLjggMjE4LjEsMjg0LjQgTDI5NS41LDM2MS44IEMzMTMuOCwzODAuMSAzNDMuNSwzODAuMSAzNjEuOCwzNjEuOCBDMzgwLjEsMzQzLjUgMzgwLjEsMzEzLjggMzYxLjgsMjk1LjUgTDM2MS44LDI5NS41IFogTTcxLDIzMC4xIEMyNy4xLDE4Ni4yIDI3LjEsMTE0LjkgNzEsNzEgQzExNC45LDI3LjEgMTg2LjIsMjcuMSAyMzAuMSw3MSBDMjc0LDExNC45IDI3NCwxODYuMiAyMzAuMSwyMzAuMSBDMTg2LjIsMjczLjkgMTE0LjgsMjczLjkgNzEsMjMwLjEgTDcxLDIzMC4xIFogTTMzNS4zLDMzNS4zIEMzMzEuNiwzMzkgMzI1LjcsMzM5IDMyMi4xLDMzNS4zIEwyNDkuNywyNjIuOSBDMjUyLDI2MC44IDI1NC40LDI1OC44IDI1Ni43LDI1Ni42IEMyNTguOSwyNTQuNCAyNjAuOSwyNTIgMjYzLDI0OS42IEwzMzUuNCwzMjIgQzMzOC45LDMyNS43IDMzOC45LDMzMS42IDMzNS4zLDMzNS4zIEwzMzUuMywzMzUuMyBaIiBpZD0iU2hhcGUiPjwvcGF0aD4KICAgICAgICAgICAgPC9nPgogICAgICAgIDwvZz4KICAgIDwvZz4KPC9zdmc+'
            ));
        }
    }

    public function output()
    {
        if (!is_search()) {
            return;
        }

        $query = get_search_query();
        $keywords = preg_split('/(\s|,)/', $query);

        $searchNotices = get_field('search_notices', 'option');
        $matchingNotices = array();

        foreach ($searchNotices as $notice) {
            if (!array_intersect(preg_split('/(\s|,)/', $notice['keywords']), $keywords)) {
                continue;
            }

            $matchingNotices[] = $notice;
        }

        add_action('search_notices', function () use ($matchingNotices) {
            $markup = '<div class="container gutter gutter-lg gutter-vertical"><div class="grid">';

            foreach ($matchingNotices as $notice) {
                $noticeMarkup = '
                    <div class="grid-xs-12">
                        <div class="notice ' . $notice['notice_class'] . '">' . $notice['notice'] . '</div>
                    </div>
                ';

                $markup .= apply_filters('search_notices/markup', $noticeMarkup, $notice);
            }

            $markup .= '</div></div>';

            echo apply_filters('search_notices/output', $markup);
        });
    }

    public function fields()
    {
        if (function_exists('acf_add_local_field_group')) :

            acf_add_local_field_group(array(
                'key' => 'group_57e2869d5225e',
                'title' => 'Search notices',
                'fields' => array(
                    array(
                        'key' => 'field_57e286a77b5b1',
                        'label' => 'Search notices',
                        'name' => 'search_notices',
                        'type' => 'repeater',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'collapsed' => '',
                        'min' => '',
                        'max' => '',
                        'layout' => 'block',
                        'button_label' => 'Lägg till rad',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_57e286ba7b5b2',
                                'label' => 'Keywords',
                                'name' => 'keywords',
                                'type' => 'text',
                                'instructions' => 'Comma separated list of keywords',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                            ),
                            array(
                                'key' => 'field_57e286dd7b5b3',
                                'label' => 'Notice level',
                                'name' => 'notice_class',
                                'type' => 'select',
                                'instructions' => 'Sets the notice style based on level',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'choices' => array(
                                    'info' => 'Info',
                                    'success' => 'Success',
                                    'danger' => 'Danger',
                                    'warning' => 'Warning',
                                ),
                                'default_value' => array(
                                    0 => 'info',
                                ),
                                'allow_null' => 0,
                                'multiple' => 0,
                                'ui' => 0,
                                'ajax' => 0,
                                'return_format' => 'value',
                                'placeholder' => '',
                            ),
                            array(
                                'key' => 'field_57e287517b5b4',
                                'label' => 'Notice',
                                'name' => 'notice',
                                'type' => 'wysiwyg',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'tabs' => 'all',
                                'toolbar' => 'basic',
                                'media_upload' => 0,
                            ),
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'search-notices',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => 1,
                'description' => '',
            ));

        endif;
    }
}
