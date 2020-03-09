<?php

class Constants {
    /* Estos son los nombres de los indicadores que se adjuntan en el archivo
     * XML generado por la librería Q2M: */
    const INDICATOR_BATTERY = "BatteryCharge";
    const INDICATOR_CONNECTION_TYPE = "ConnectionType";
    const INDICATOR_CPU_PERCENTAGE = "CPUConsumption";
    const INDICATOR_ENVIRONMENT_LIGHT = "EnvironmentLight";
    const INDICATOR_JITTER = "Jitter";
    const INDICATOR_LATENCY = "Latency";
    const INDICATOR_MEMORY_PERCENTAGE = "MemoryConsumption";
    const INDICATOR_MEMORY_MB = "MemoryConsumptionMB";
    const INDICATOR_PACKET_LOSS = "PacketLoss";
    const INDICATOR_IS_CHARGING = "PhoneCharging";
    const INDICATOR_IS_CONNECTED = "PhoneConnectedToANetwork";
    const INDICATOR_PROXIMITY = "Proximity";
    const INDICATOR_BRIGHTNESS = "ScreenBrightness";
    const INDICATOR_SIGNAL_DBM = "SignalStrength";
    const INDICATOR_USER_LATENCY  = "UserPerceivedLatency";
    
    /* Posibles puntajes que puede elegir el usuario para su experiencia: */
    const SCORE_0 = "Mala";
    const SCORE_1 = "Regular";
    const SCORE_2 = "Buena";
}