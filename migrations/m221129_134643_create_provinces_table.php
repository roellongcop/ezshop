<?php

/**
 * Handles the creation of table `{{%provinces}}`.
 */
class m221129_134643_create_provinces_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%provinces}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'name' => $this->string()->notNull()->unique(),
            'no' => $this->tinyInteger(2),
        ]));
        
        $this->seed();
    }


    public function seed()
    {
        $rows = [];

        foreach($this->data() as $data) {
            list($name, $no) = $data;

            $rows[] = [
                'name' => $name,
                'no' => $no,
            ];
        }

        if ($rows) {
            $arr = array_chunk($rows, 1000);
            $columns = array_keys($rows[0]);
            foreach ($arr as $r) {
                $this->batchInsert($this->tableName(), $columns, $r);
            }
        }
    }

    public function data()
    {
        return [
            array('ABRA', 1),
            array('AGUSAN DEL NORTE', 2),
            array('AGUSAN DEL SUR', 3),
            array('AKLAN', 4),
            array('ALBAY', 5),
            array('ANTIQUE', 6),
            array('BASILAN', 7),
            array('BATAAN', 8),
            array('BATANES', 9),
            array('BATANGAS', 10),
            array('BENGUET', 11),
            array('BOHOL', 12),
            array('BUKIDNON', 13),
            array('BULACAN', 14),
            array('CAGAYAN', 15),
            array('CAMARINES NORTE', 16),
            array('CAMARINES SUR', 17),
            array('CAMIGUIN', 18),
            array('CAPIZ', 19),
            array('CATANDUANES', 20),
            array('CAVITE', 21),
            array('CEBU', 22),
            array('DAVAO (DAVAO DEL NORTE)', 23),
            array('DAVAO DEL SUR', 24),
            array('DAVAO ORIENTAL', 25),
            array('EASTERN SAMAR', 26),
            array('IFUGAO', 27),
            array('ILOCOS NORTE', 28),
            array('ILOCOS SUR', 29),
            array('ILOILO', 30),
            array('ISABELA', 31),
            array('KALINGA', 32),
            array('LA UNION', 33),
            array('LAGUNA', 34),
            array('LANAO DEL NORTE', 35),
            array('LANAO DEL SUR', 36),
            array('LEYTE', 37),
            array('MAGUINDANAO', 38),
            array('NCR - Manila', 39),
            array('MARINDUQUE', 40),
            array('MASBATE', 41),
            array('MISAMIS OCCIDENTAL', 42),
            array('MISAMIS ORIENTAL', 43),
            array('MOUNTAIN PROVINCE', 44),
            array('NEGROS OCCIDENTAL', 45),
            array('NEGROS ORIENTAL', 46),
            array('COTABATO (NORTH COTABATO)', 47),
            array('NORTHERN SAMAR', 48),
            array('NUEVA ECIJA', 49),
            array('NUEVA VIZCAYA', 50),
            array('OCCIDENTAL MINDORO', 51),
            array('ORIENTAL MINDORO', 52),
            array('PALAWAN', 53),
            array('PAMPANGA', 54),
            array('PANGASINAN', 55),
            array('QUEZON', 56),
            array('QUIRINO', 57),
            array('RIZAL', 58),
            array('ROMBLON', 59),
            array('SAMAR (WESTERN SAMAR)', 60),
            array('SIQUIJOR', 61),
            array('SORSOGON', 62),
            array('SOUTH COTABATO', 63),
            array('SOUTHERN LEYTE', 64),
            array('SULTAN KUDARAT', 65),
            array('SULU', 66),
            array('SURIGAO DEL NORTE', 67),
            array('SURIGAO DEL SUR', 68),
            array('TARLAC', 69),
            array('TAWI-TAWI', 70),
            array('ZAMBALES', 71),
            array('ZAMBOANGA DEL NORTE', 72),
            array('ZAMBOANGA DEL SUR', 73),
            array('NCR 2', 74),
            array('NCR 3', 75),
            array('NCR 4', 76),
            array('AURORA', 77),
            array('BILIRAN', 78),
            array('GUIMARAS', 79),
            array('SARANGANI', 80),
            array('APAYAO', 81),
            array('COMPOSTELA VALLEY', 82),
            array('ZAMBOANGA SIBUGAY', 83),
            array('DINAGAT ISLANDS', 85),
            array('COTABATO CITY', 98)
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName());
    }
}