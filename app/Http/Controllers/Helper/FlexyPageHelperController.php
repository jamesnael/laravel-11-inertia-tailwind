<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Admin\Homepage\SupportedByController;
use App\Http\Controllers\Controller;
use App\Models\FlexyFaq;
use App\Models\FlexyFaqDetail;
use App\Models\FlexyHistory;
use App\Models\FlexyMedia;
use App\Models\FlexyParagraph;
use App\Models\FlexyParagraphDetail;
use App\Models\FlexyQuote;
use App\Models\FlexyReference;
use App\Models\FlexyReferenceDetail;
use App\Models\FlexyTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FlexyPageHelperController
{
    public function store_flexy_section($section, $flexypage)
    {
        foreach ($section as $key => $value) {
            if ($value['tipe'] == 'Paragraph') {
                $paragraph = FlexyParagraph::create([
                    'flexy_id' => $flexypage->id,
                    'title' => $value['title'],
                    'content' => $value['content'],
                    'title_size' => $value['title_size'] == '' ? 'h3' : $value['title_size'],
                    'position' => $key + 1
                ]);

                if (isset($value['detail'])) {
                    foreach ($value['detail'] as $subval) {
                        $icon = '';
                        if (isset($subval['icons']) && $subval['icons']) {
                            $file_name = $subval['title'] . '-' . uniqid() . '.' . $subval['icons']->getClientOriginalExtension();
                            $path = Storage::disk('public')->putFileAs('flexypage/icon', $subval['icons'], $file_name);
                            $icon = $path;
                        }

                        FlexyParagraphDetail::create([
                            'flexy_id' => $flexypage->id,
                            'flexy_paragraph_id' => $paragraph->id,
                            'title' => $subval['title'],
                            'description' => $subval['description'],
                            'button_label' => $subval['button_label'],
                            'button_url' => $subval['button_url'],
                            'icon' => $icon ?? null,
                        ]);
                    }
                }
            } else if ($value['tipe'] == 'Table') {
                FlexyTable::create([
                    'flexy_id' => $flexypage->id,
                    'content' => $value['content'],
                    'position' => $key + 1
                ]);
            } else if ($value['tipe'] == 'Image') {
                $image = '';
                if (isset($value['images']) && $value['images']) {
                    $file_name = $value['title'] . '-' . uniqid() . '.' . $value['images']->getClientOriginalExtension();
                    $path = Storage::disk('public')->putFileAs('flexypage/image', $value['images'], $file_name);
                    $image = $path;
                }
                FlexyMedia::create([
                    'flexy_id' => $flexypage->id,
                    'tipe' => 'Image',
                    'title' => $value['title'],
                    'source' => $value['source'],
                    'position' => $key + 1,
                    'image' => $image ?? null
                ]);
            } else if ($value['tipe'] == 'Video') {
                FlexyMedia::create([
                    'flexy_id' => $flexypage->id,
                    'tipe' => 'Video',
                    'title' => $value['title'],
                    'source' => $value['source'],
                    'position' => $key + 1,
                    'video' => $value['video']
                ]);
            } else if ($value['tipe'] == 'Pull Quote') {
                FlexyQuote::create([
                    'flexy_id' => $flexypage->id,
                    'tipe' => 'Pull Quote',
                    'quote' => $value['quote'],
                    'author' => $value['author'],
                    'position' => $key + 1,
                ]);
            } else if ($value['tipe'] == 'Quote') {
                FlexyQuote::create([
                    'flexy_id' => $flexypage->id,
                    'tipe' => 'Quote',
                    'quote' => $value['quote'],
                    'author' => $value['author'],
                    'position' => $key + 1,
                ]);
            } else if ($value['tipe'] == 'Reference') {
                $reference = FlexyReference::create([
                    'flexy_id' => $flexypage->id,
                    'position' => $key + 1,
                ]);

                if (isset($value['detail'])) {
                    foreach ($value['detail'] as $subval) {
                        FlexyReferenceDetail::create([
                            'flexy_id' => $flexypage->id,
                            'flexy_reference_id' => $reference->id,
                            'content' => $subval['content'],
                            'title' => $subval['title'],
                        ]);
                    }
                }
            } else if ($value['tipe'] == 'FAQ') {
                $faq = FlexyFaq::create([
                    'flexy_id' => $flexypage->id,
                    'position' => $key + 1,
                ]);

                if (isset($value['detail'])) {
                    foreach ($value['detail'] as $subval) {
                        FlexyFaqDetail::create([
                            'flexy_id' => $flexypage->id,
                            'flexy_faq_id' => $faq->id,
                            'question' => $subval['question'],
                            'answer' => $subval['answer']
                        ]);
                    }
                }
            } else if ($value['tipe'] == 'History') {
                $faq = FlexyHistory::create([
                    'flexy_id' => $flexypage->id,
                    'position' => $key + 1,
                ]);
            }
        }
    }

    public function update_flexy_section($section, $flexypage)
    {
        $paragraph_id = [];
        $table_id = [];
        $image_id = [];
        $video_id = [];
        $pull_quote_id = [];
        $quote_id = [];
        $reference_id = [];
        $faq_id = [];
        $history_id = [];

        foreach ($section as $key => $value) {
            if ($value['tipe'] == 'Paragraph') {
                if (isset($value['id'])) {
                    //update paragraph
                    $paragraph = FlexyParagraph::find($value['id']);
                    $paragraph->title = $value['title'];
                    $paragraph->content = $value['content'];
                    $paragraph->title_size = $value['title_size'] == '' ? 'h3' : $value['title_size'];
                    $paragraph->position = $key + 1;
                    $paragraph->save();
                    $paragraph_id[] = $paragraph->id;
                } else {
                    //create new paragraph
                    $paragraph = FlexyParagraph::create([
                        'flexy_id' => $flexypage->id,
                        'title' => $value['title'],
                        'content' => $value['content'],
                        'title_size' => $value['title_size'] == '' ? 'h3' : $value['title_size'],
                        'position' => $key + 1
                    ]);
                    $paragraph_id[] = $paragraph->id;
                }


                if (isset($value['detail'])) {
                    $paragraph_detail_id = [];
                    foreach ($value['detail'] as $subval) {
                        if (isset($subval['id'])) {
                            $icon = '';
                            if (isset($subval['icons']) && $subval['icons']) {
                                $file_name = $subval['title'] . '-' . uniqid() . '.' . $subval['icons']->getClientOriginalExtension();
                                $path = Storage::disk('public')->putFileAs('flexypage/icon', $subval['icons'], $file_name);
                                $icon = $path;
                            }

                            //update detail
                            $paragraph_detail_id[] = $subval['id'];
                            $paragraph_detail = FlexyParagraphDetail::find($subval['id']);
                            $paragraph_detail->title = $subval['title'];
                            $paragraph_detail->description =  $subval['description'];
                            $paragraph_detail->button_label = $subval['button_label'];
                            $paragraph_detail->button_url = $subval['button_url'];

                            if (isset($subval['icons'])) {
                                $paragraph_detail->icon =  $icon;
                            }

                            $paragraph_detail->save();
                        } else {
                            $icon = '';
                            if (isset($subval['icons']) && $subval['icons']) {
                                $file_name = $subval['title'] . '-' . uniqid() . '.' . $subval['icons']->getClientOriginalExtension();
                                $path = Storage::disk('public')->putFileAs('flexypage/icon', $subval['icons'], $file_name);
                                $icon = $path;
                            }

                            //create new detail
                            $paragraph_details = FlexyParagraphDetail::create([
                                'flexy_id' => $flexypage->id,
                                'flexy_paragraph_id' => $paragraph->id,
                                'title' => $subval['title'],
                                'description' => $subval['description'],
                                'icon' => $icon ?? null,
                                'button_label' => $subval['button_label'],
                                'button_url' => $subval['button_url'],
                            ]);

                            $paragraph_detail_id[] = $paragraph_details->id;
                        }
                    }
                    //delete detail
                    FlexyParagraphDetail::where('flexy_paragraph_id', $paragraph->id)->whereNotIn('id', $paragraph_detail_id)->delete();
                }
            } else if ($value['tipe'] == 'Table') {

                if (isset($value['id'])) {
                    //update Table
                    $table = FlexyTable::find($value['id']);
                    $table->content = $value['content'];
                    $table->position = $key + 1;
                    $table->save();
                    $table_id[] = $table->id;
                } else {
                    //Create Table
                    $table = FlexyTable::create([
                        'flexy_id' => $flexypage->id,
                        'content' => $value['content'],
                        'position' => $key + 1
                    ]);
                    $table_id[] = $table->id;
                }
            } else if ($value['tipe'] == 'Image') {
                if (isset($value['id'])) {
                    //update Image
                    $image = FlexyMedia::find($value['id']);
                    $image_id[] = $image->id;

                    if (isset($value['images']) && $value['images']) {
                        $file_name = $value['title'] . '-' . uniqid() . '.' . $value['images']->getClientOriginalExtension();
                        $path = Storage::disk('public')->putFileAs('flexypage/image', $value['images'], $file_name);
                        $image->image = $path;
                    }

                    $image->title = $value['title'];
                    $image->source = $value['source'];
                    $image->position = $key + 1;
                    $image->save();
                } else {
                    //create new image
                    $image = '';
                    if (isset($value['images']) && $value['images']) {
                        $file_name = $value['title'] . '-' . uniqid() . '.' . $value['images']->getClientOriginalExtension();
                        $path = Storage::disk('public')->putFileAs('flexypage/image', $value['images'], $file_name);
                        $image = $path;
                    }

                    $image = FlexyMedia::create([
                        'flexy_id' => $flexypage->id,
                        'tipe' => 'Image',
                        'title' => $value['title'],
                        'source' => $value['source'],
                        'position' => $key + 1,
                        'image' => $image ?? null
                    ]);
                    $image_id[] = $image->id;
                }
            } else if ($value['tipe'] == 'Video') {
                if (isset($value['id'])) {
                    //update Video
                    $video = FlexyMedia::find($value['id']);
                    $video_id[] = $video->id;
                    $video->title = $value['title'];
                    $video->source = $value['source'];
                    $video->video = $value['video'];
                    $video->position = $key + 1;
                    $video->save();
                } else {
                    //create new video
                    $video = FlexyMedia::create([
                        'flexy_id' => $flexypage->id,
                        'tipe' => 'Video',
                        'title' => $value['title'],
                        'source' => $value['source'],
                        'position' => $key + 1,
                        'video' => $value['video']
                    ]);
                    $video_id[] = $video->id;
                }
            } else if ($value['tipe'] == 'Pull Quote') {
                if (isset($value['id'])) {
                    //update pull quote
                    $pull_quote = FlexyQuote::find($value['id']);
                    $pull_quote_id[] = $pull_quote->id;
                    $pull_quote->quote = $value['quote'];
                    $pull_quote->author = $value['author'];
                    $pull_quote->position = $key + 1;
                    $pull_quote->save();
                } else {
                    //create new pull quote
                    $pull_quote = FlexyQuote::create([
                        'flexy_id' => $flexypage->id,
                        'tipe' => 'Pull Quote',
                        'quote' => $value['quote'],
                        'author' => $value['author'],
                        'position' => $key + 1,
                    ]);
                    $pull_quote_id[] = $pull_quote->id;
                }
            } else if ($value['tipe'] == 'Quote') {
                if (isset($value['id'])) {
                    //update pull quote
                    $quote = FlexyQuote::find($value['id']);
                    $quote_id[] = $quote->id;
                    $quote->quote = $value['quote'];
                    $quote->author = $value['author'];
                    $quote->position = $key + 1;
                    $quote->save();
                } else {
                    //create new pull quote
                    $quote = FlexyQuote::create([
                        'flexy_id' => $flexypage->id,
                        'tipe' => 'Quote',
                        'quote' => $value['quote'],
                        'author' => $value['author'],
                        'position' => $key + 1,
                    ]);
                    $quote_id[] = $quote->id;
                }
            } else if ($value['tipe'] == 'Reference') {
                if (isset($value['id'])) {
                    $reference = FlexyReference::find($value['id']);
                    $reference_id[] = $reference->id;
                    $reference->position = $key + 1;
                    $reference->save();
                } else {
                    $reference = FlexyReference::create([
                        'flexy_id' => $flexypage->id,
                        'position' => $key + 1,
                    ]);
                    $reference_id[] = $reference->id;
                }

                if (isset($value['detail'])) {
                    $reference_detail_id = [];
                    foreach ($value['detail'] as $subval) {
                        if (isset($subval['id'])) {
                            //update new reference detail
                            $reference_detail = FlexyReferenceDetail::find($subval['id']);
                            $reference_detail_id[] = $reference_detail->id;
                            $reference_detail->content = $subval['content'];
                            $reference_detail->title = $subval['title'];
                            $reference_detail->save();
                        } else {
                            //create new reference detail
                            if (isset($subval['title']) && isset($subval['content'])) {
                                $reference_detail = FlexyReferenceDetail::create([
                                    'flexy_id' => $flexypage->id,
                                    'flexy_reference_id' => $reference->id,
                                    'content' => $subval['content'],
                                    'title' => $subval['title'],
                                ]);
                                $reference_detail_id[] = $reference_detail->id;
                            }
                        }
                    }

                    //delete unused reference detail
                    FlexyReferenceDetail::where('flexy_id', $flexypage->id)
                        ->where('flexy_reference_id', $reference->id)
                        ->whereNotIn('id', $reference_detail_id)
                        ->delete();
                }
            } else if ($value['tipe'] == 'FAQ') {
                if (isset($value['id'])) {
                    $faq = FlexyFaq::find($value['id']);
                    $faq_id[] = $faq->id;
                    $faq->position = $key + 1;
                    $faq->save();
                } else {
                    $faq = FlexyFaq::create([
                        'flexy_id' => $flexypage->id,
                        'position' => $key + 1,
                    ]);
                    $faq_id[] = $faq->id;
                }

                if (isset($value['detail'])) {
                    $faq_detail_id = [];
                    foreach ($value['detail'] as $subval) {
                        if (isset($subval['id'])) {
                            //create new faq detail
                            $faq_detail = FlexyFaqDetail::find($subval['id']);
                            $faq_detail_id[] = $faq_detail->id;
                            $faq_detail->question = $subval['question'];
                            $faq_detail->answer = $subval['answer'];
                            $faq_detail->save();
                        } else {
                            //update new faq detail
                            $faq_detail = FlexyFaqDetail::create([
                                'flexy_id' => $flexypage->id,
                                'flexy_faq_id' => $faq->id,
                                'question' => $subval['question'],
                                'answer' => $subval['answer']
                            ]);
                            $faq_detail_id[] = $faq_detail->id;
                        }
                    }

                    //delete unused faq detail
                    FlexyFaqDetail::where('flexy_id', $flexypage->id)
                        ->where('flexy_faq_id', $faq->id)
                        ->whereNotIn('id', $faq_detail_id)
                        ->delete();
                }
            } else if ($value['tipe'] == 'History') {
                if (isset($value['id'])) {
                    $history = FlexyHistory::find($value['id']);
                    $history_id[] = $history->id;
                    $history->position = $key + 1;
                    $history->save();
                } else {
                    $history = FlexyHistory::create([
                        'flexy_id' => $flexypage->id,
                        'position' => $key + 1,
                    ]);
                    $history_id[] = $history->id;
                }
            }
        }
        //delete all unused relation
        FlexyParagraph::where('flexy_id', $flexypage->id)->whereNotIn('id', $paragraph_id)->delete();
        FlexyParagraphDetail::where('flexy_id', $flexypage->id)->whereNotIn('flexy_paragraph_id', $paragraph_id)->delete();
        FlexyTable::where('flexy_id', $flexypage->id)->whereNotIn('id', $table_id)->delete();
        FlexyMedia::where('flexy_id', $flexypage->id)->where('tipe', 'Image')->whereNotIn('id', $image_id)->delete();
        FlexyMedia::where('flexy_id', $flexypage->id)->where('tipe', 'Video')->whereNotIn('id', $video_id)->delete();
        FlexyQuote::where('flexy_id', $flexypage->id)->where('tipe', 'Pull Quote')->whereNotIn('id', $pull_quote_id)->delete();
        FlexyQuote::where('flexy_id', $flexypage->id)->where('tipe', 'Quote')->whereNotIn('id', $quote_id)->delete();
        FlexyReference::where('flexy_id', $flexypage->id)->whereNotIn('id', $reference_id)->delete();
        FlexyReferenceDetail::where('flexy_id', $flexypage->id)->whereNotIn('flexy_reference_id', $reference_id)->delete();
        FlexyFaq::where('flexy_id', $flexypage->id)->whereNotIn('id', $faq_id)->delete();
        FlexyFaqDetail::where('flexy_id', $flexypage->id)->whereNotIn('flexy_faq_id', $faq_id)->delete();
        FlexyHistory::where('flexy_id', $flexypage->id)->whereNotIn('id', $history_id)->delete();
    }
}
