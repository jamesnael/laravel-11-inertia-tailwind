<?php

namespace App\Console\Commands;

use App\Mail\UserRegistrationExpiredNotificationMail;
use App\Models\Karyawan;
use App\Models\ProductCompany;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class WipeExpiredRegistration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:wipeexpiredregis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron for delete the expired registration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            \DB::beginTransaction();
            $data = Karyawan::where('approval_status', 'Waiting Verification')
            ->where('status',false)
            ->where('created_at', '<=', Carbon::now()->subHour(3))
            ->get();

            foreach($data as $value) {
                $value->approval_status = 'Expired';
                $value->reject_reason = 'Expired';
                $value->save();

                Mail::to($value->email)->send(new UserRegistrationExpiredNotificationMail($value));
                
                ProductCompany::where('user_id',$value->id)->delete();

                $value->delete();
            }
            \DB::commit();
        } catch (Exception $e) {
            \DB::rollback();
        }
    }
}
