<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Contact\ListRequest;
use App\Http\Requests\Admin\Contact\StatusUpdateRequest;

use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

use App\Consts\ContactConsts;

class ContactController extends Controller
{
    //
    public function list(ListRequest $request)
    {
        $input = $request->validated();

        // CSV出力の場合、検索条件をセッションに保持してリダイレクト
        if ($request->input('csv_export') === 'csv_export') {
            $request->session()->put('csv_export', $input);
            return redirect()->route('admin.contact.csv_export');
        }

        $model = new Contact();
        $lists = $model->getAdminLists($input);

        return view('admin.contact.list', compact(['lists', 'input']));
    }


    public function csv_export(Request $request)
    {
        // レコードを取得
        $input = $request->session()->pull('csv_export');
        $model = new Contact();
        $query = $model->getAdminCsvExport($input);

        // ヘッダー情報
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment;'
        ];

        // ファイル名
        $fileName = 'お問い合わせ';
        if (Arr::exists($input, 'created_at_from') && $input['created_at_from'] && Arr::exists($input, 'created_at_to') && $input['created_at_to']) {
            $fileName = $fileName . $input['created_at_from'] . '～' . $input['created_at_to'] . '.csv';
        } elseif (Arr::exists($input, 'created_at_from') && $input['created_at_from']) {
            $fileName = $fileName . $input['created_at_from'] . '～' . '.csv';
        } elseif (Arr::exists($input, 'created_at_to') && $input['created_at_to']) {
            $fileName = $fileName . '～' . $input['created_at_to'] . '.csv';
        } else {
            $fileName = $fileName . '_all.csv';
        }

        $callback = function() use ($query)
        {
            // ストリームを作成してファイルに書き込めるようにする
            $stream = fopen('php://output', 'w');
            // CSVのヘッダ行の定義
            $head = [
                'お問い合わせNO',
                '投稿日',
                '氏名',
                'メールアドレス',
                'お問い合わせ内容',
                'ステータス',
            ];

            // UTF-8からSJISにフォーマットを変更してExcelの文字化け対策
            mb_convert_variables('SJIS', 'UTF-8', $head);
            fputcsv($stream, $head);

            // CSVファイルのデータレコードにお問い合わせ情報を挿入
            foreach ($query->cursor() as $contact) {
                $data = [
                    $contact->no,
                    $contact->created_at->format('Y年m月d日H時i分s秒'),
                    $contact->name,
                    $contact->mail_address,
                    $contact->mail_body,
                    ContactConsts::STATUS_LIST[$contact->status],
                ];

                mb_convert_variables('SJIS', 'UTF-8', $data);
                fputcsv($stream, $data);
            }

            fclose($stream);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }


    public function detail($id)
    {

        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'bail|required|integer|exists:contacts']
        );

        if ($validator->fails()) {
            return redirect()->route('admin.contact.list')->with('msg_failure', '不正な値が入力されました。');
        }

        $model = new Contact();
        $detail = $model->find($id);

        return view('admin.contact.detail', compact('detail'));
    }


    public function status_update(StatusUpdateRequest $request)
    {
        $data = $request->validated();
        DB::transaction(function () use ($data) {
            $model = new Contact();
            $model->updateContactStatus($data);
        });

        return redirect()->route('admin.contact.detail', ['id' => $data['id']])->with('msg_success', 'ステータスを更新しました。');
    }
}
