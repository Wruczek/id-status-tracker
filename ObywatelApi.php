<?php

namespace Wruczek\IdStatusTracker;

class ObywatelApi {

    private $applicationIdRegex = "/\d{7}\/\d{4}\/\d{7}\/\d{2}$/m";
    private $baseUrl = "https://obywatel.gov.pl";
    private $applicationCheckEndpoint = "/esrvProxy/proxy/sprawdzStatusWniosku?numerWniosku=%s";

    /**
     * Returns json describing current status of ID application
     * @param $applicationId string
     * @param bool $returnAsArray true to returns as array, false to returns as object
     * @return object When applicationId is invalid (code 0x01),
     *         request cannot be made (code 0x02) or returned JSON is invalid (code 0x03)
     */
    public function getIdStatus($applicationId, $returnAsArray = false) {
        if (!$this->validateApplicationId($applicationId)) {
            throw new IdStatusTrackerException("Invalid applicationId", 0x01);
        }

        $url = sprintf($this->getUrl($this->applicationCheckEndpoint), urlencode($applicationId));
        $response = @file_get_contents($url);

        if ($response === false) {
            throw new IdStatusTrackerException("Error sending request", 0x02);
        }

        $json = json_decode($response, $returnAsArray);

        if ($json === false) {
            throw new IdStatusTrackerException("Cannot decode response JSON", 0x03);
        }

        return $json;
    }

    /**
     * Returns true when $applicationId is valid, otherwise false
     * @param $applicationId string applicationId to check
     * @return bool
     */
    public function validateApplicationId($applicationId) {
        return preg_match($this->applicationIdRegex, $applicationId) === 1;
    }

    /**
     * Returns description of the provided applicationState and idState
     * @param $applicationState string
     * @param $idState string
     * @return null|string Returns description as string, null if not found
     */
    public function getStatusDescription($applicationState, $idState) {
        switch ($applicationState) {
            case "WPROWADZONY":
                return "Wniosek o dowód przyjęty w urzędzie";
            case "ZAWIESZONY":
            case "ODMOWA_ART_32":
            case "BEZ_ROZPOZNANIA":
            case "ODWOLANIE":
            case "ZAKONCZONY_ODMOWNIE":
                return "Skontaktuj się z urzędem, w którym składałeś wniosek";
            case "NOWY":
            case "PRZYJETY_PRZEZ_SPD":
            case "PRZEKAZANY_DO_SPD":
                return "Dowód w realizacji w urzędzie";
            case "SPERSONALIZOWANY":
                switch ($idState) {
                    case "SPERSONALIZOWANY":
                    case "WYSLANY":
                        return "Dowód w realizacji w urzędzie";
                    case "PRZYJETY_PRZEZ_URZAD":
                        return "Dowód gotowy do odebrania";
                    default:
                        return null;
                }
            case "NIEDOPUSZCZONY_DO_PRODUKCJI":
                return "Skontaktuj się z urzędem, w którym składałeś wniosek";
            default:
                return null;
        }
    }

    /**
     * Returns bseUrl combined with $endpoint
     */
    private function getUrl($endpoint) {
        return $this->baseUrl . $endpoint;
    }
}

class IdStatusTrackerException extends \Exception {}
