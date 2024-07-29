<?php

add_filter('upload_mimes','add_svg_file');

function add_svg_file( $file_types ) { $new_filetypes = array(); $new_filetypes['svg'] = 'image/svg+xml'; $file_types = array_merge( $file_types, $new_filetypes ); return $file_types; }
                                                                                        