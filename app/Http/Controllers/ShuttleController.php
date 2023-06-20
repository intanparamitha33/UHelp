<?php

namespace App\Http\Controllers;
use App\Models\Shuttle;
use App\Http\Requests\StoreShuttleRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateShuttleRequest;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
use Carbon\Carbon;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ShuttleController extends Controller
{
    public function savedata(Request $request){
        $destinationFrom = $request->input('place_departure');
        $destinationTo = $request->input('place_return');
        $departureTime = $request->input('time_departure');
        $returnTime = $request->input('time_return');
        $keperluan = $request->input('kebutuhan');
        $tanggal = true;
        $tomorrow = Carbon::tomorrow()->format('l');
        $date =  Carbon::tomorrow();

        $model = new Shuttle();
        $model->turun = $destinationFrom;
        $model->naik = $destinationTo;
        $model->jamAlsut = $departureTime;
        $model->keperluan = $keperluan;
        $model->hari = $tomorrow;
        $model->jamAnggrek = $returnTime;
        $model->departdate = $date;
        $model->sumtanggal = $tanggal;


    // Save the model to the database
        $model->save();
        $datas = Shuttle::all();
        return view('clickandsit.clickandsit-fill',compact('datas'));
    }

    public function cobapython($idShuttle)
    {
        $anjay = Shuttle::find($idShuttle);
        $pythonScriptPath = public_path('test.py');
        $berangkat = $anjay->jamAnggrek;
        $jamberangkat = $anjay->turun;
        $balik = $anjay->jamAlsut;
        $jambalik = $anjay->naik;
        $departdate = date('d-m-Y', strtotime($anjay->departdate));
        // Escape the parameter value
        $parameter = [
            escapeshellarg('zberlam@gmail.com'),
            escapeshellarg($departdate),
            escapeshellarg('2502040612'),
            escapeshellarg('Zaka Keren'),
            escapeshellarg('Dosen'),
            escapeshellarg('082147279041'),
            escapeshellarg($berangkat),
            escapeshellarg($jamberangkat),
            escapeshellarg($balik),
            escapeshellarg($jambalik)
        ];
        $parameterString = implode(' ', $parameter);

        $command = "python \"{$pythonScriptPath}\" {$parameterString}";

        $output = shell_exec($command);

        // Process the output as needed
        dd($output);
    // Process the output as needed
    }

    public function routingawal()
    {
        // $seleniumCommand = "java -jar /public/selenium-server-4.9.0.jar standalone";
        // $process = new Process([$seleniumCommand]);
        // $process->start();
        // usleep(5000000);
        $seleniumCommand = "java -jar " . public_path('selenium-server-4.9.0.jar') . " standalone";
        exec($seleniumCommand);
        // $process = new Process([$seleniumCommand]);

        try {
            // $process->start();
            // usleep(5000000);
            $host = 'http://localhost:4444/wd/hub'; // Selenium server URL
            $capabilities = DesiredCapabilities::chrome(); // or any other browser
            $driver = RemoteWebDriver::create($host, $capabilities);

            $driver->get('https://forms.gle/dKcynjUvbwggiQdx5');
            $wait = new WebDriverWait($driver, 60);

            $inputElement = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::className('whsOnd'))
            );
            $inputElement->sendKeys("Alogha@gmail.com");

            $nextButton = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::className('NPEfkd'))
            );
            $nextButton->click();

            $woke = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::className('AB7Lab'))
            );
            $woke->click();

            $nextButton2 = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath("//span[contains(text(),'Berikutnya')]"))
            );
            $nextButton2->click();

            $tanggalan = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::cssSelector('input[type="date"].whsOnd.zHQkBf'))
            );
            $tanggalan->sendKeys('10-05-2022');

            $nextButton3 = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath("//span[contains(text(),'Berikutnya')]"))
            );
            $nextButton3->click();

            $BinusianId = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('(//input[@type="text"])[1]'))
            );
            $BinusianId->sendKeys("Aloha America");

            $Namaku = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('(//input[@type="text"])[2]'))
            );
            $Namaku->sendKeys("Kaneki ken");

            $Unit = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('(//input[@type="text"])[3]'))
            );
            $Unit->sendKeys("Beban Binus");

            $option1 = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('//div[@aria-label="W gabut"]'))
            );
            $option1->click();

            $telpon = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('(//input[@type="text"])[5]'))
            );
            $telpon->sendKeys("088888888");

            $harinya = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('//div[@aria-label="Senin"]'))
            );
            $harinya->click();

            $nextButton4 = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath("//span[contains(text(),'Berikutnya')]"))
            );
            $nextButton4->click();

            $jam1 = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('//div[@aria-label="Jam 2"]'))
            );
            $jam1->click();

            $turundi = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('//div[@aria-label="Binus Alsut"]'))
            );
            $turundi->click();

            $Finish = $wait->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath("//span[contains(text(),'Kirim')]"))
            );
            $Finish->click();
            // $process->stop();
        } catch (ProcessFailedException $exception) {
            // Handle the process exception if needed
        }
        // $host = 'http://localhost:4444/wd/hub'; // Selenium server URL
        // $capabilities = DesiredCapabilities::chrome(); // or any other browser
        // $driver = RemoteWebDriver::create($host, $capabilities);

        // $driver->get('https://forms.gle/dKcynjUvbwggiQdx5');
        // $wait = new WebDriverWait($driver, 60);

        // $inputElement = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::className('whsOnd'))
        // );
        // $inputElement->sendKeys("Alogha@gmail.com");

        // $nextButton = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::className('NPEfkd'))
        // );
        // $nextButton->click();

        // $woke = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::className('AB7Lab'))
        // );
        // $woke->click();

        // $nextButton2 = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath("//span[contains(text(),'Berikutnya')]"))
        // );
        // $nextButton2->click();

        // $tanggalan = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::cssSelector('input[type="date"].whsOnd.zHQkBf'))
        // );
        // $tanggalan->sendKeys('10-05-2022');

        // $nextButton3 = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath("//span[contains(text(),'Berikutnya')]"))
        // );
        // $nextButton3->click();

        // $BinusianId = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('(//input[@type="text"])[1]'))
        // );
        // $BinusianId->sendKeys("Aloha America");

        // $Namaku = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('(//input[@type="text"])[2]'))
        // );
        // $Namaku->sendKeys("Kaneki ken");

        // $Unit = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('(//input[@type="text"])[3]'))
        // );
        // $Unit->sendKeys("Beban Binus");

        // $option1 = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('//div[@aria-label="W gabut"]'))
        // );
        // $option1->click();

        // $telpon = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('(//input[@type="text"])[5]'))
        // );
        // $telpon->sendKeys("088888888");

        // $harinya = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('//div[@aria-label="Senin"]'))
        // );
        // $harinya->click();

        // $nextButton4 = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath("//span[contains(text(),'Berikutnya')]"))
        // );
        // $nextButton4->click();

        // $jam1 = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('//div[@aria-label="Jam 2"]'))
        // );
        // $jam1->click();

        // $turundi = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath('//div[@aria-label="Binus Alsut"]'))
        // );
        // $turundi->click();

        // $Finish = $wait->until(
        //     WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::xpath("//span[contains(text(),'Kirim')]"))
        // );
        // $Finish->click();

        // $driver->quit();
    }
}

