<?php

/**
 *    oooooooooo.                                                        o8o            ooo        ooooo   .oooooo.   ooooooooooooo oooooooooo.
 *    `888'   `Y8b                                                       `"'            `88.       .888'  d8P'  `Y8b  8'   888   `8 `888'   `Y8b
 *     888      888 oooo    ooo ooo. .oo.    .oooo.   ooo. .oo.  .oo.   oooo   .ooooo.   888b     d'888  888      888      888       888      888
 *     888      888  `88.  .8'  `888P"Y88b  `P  )88b  `888P"Y88bP"Y88b  `888  d88' `"Y8  8 Y88. .P  888  888      888      888       888      888
 *     888      888   `88..8'    888   888   .oP"888   888   888   888   888  888        8  `888'   888  888      888      888       888      888
 *     888     d88'    `888'     888   888  d8(  888   888   888   888   888  888   .o8  8    Y     888  `88b    d88'      888       888     d88'
 *    o888bood8P'       .8'     o888o o888o `Y888""8o o888o o888o o888o o888o `Y8bod8P' o8o        o888o  `Y8bood8P'      o888o     o888bood8P'
 *                  .o..P'
 *                  `Y8P'
 *
 *
 *    This plugin is open source, allowing you to modify and duplicate it as you wish.
 *    Feel free to customize it according to your needs and contribute to its development.
 *    Your feedback and improvements are always welcome!
 *
 *    @name DynamicMOTD
 *    @author Kronnosy
 *    @version 1.0.0
 */

namespace Kronnosy\DynamicMOTD\task;

use Kronnosy\DynamicMOTD\
{
    DynamicMOTD
};

use pocketmine\
{
    scheduler\Task
};

class DynamicTask extends Task
{
    /**
     * @var DynamicMOTD $dynamicMOTD
     */
    private DynamicMOTD $dynamicMOTD;

    /**
     * @var array $motds
     */
    private array $motds;

    /**
     * @var int $currentIndex
     */
    private int $currentIndex = 0;

    /**
     * @param DynamicMOTD $dynamicMOTD
     * @param array $motds
     */
    public function __construct(DynamicMOTD $dynamicMOTD, array $motds)
    {
        $this->dynamicMOTD = $dynamicMOTD;
        $this->motds = $motds;
    }

    /**
     * @return void
     */
    public function onRun(): void
    {
        if (empty($this->motds)) {
            return;
        }

        $onlinePlayers = count($this->dynamicMOTD->getServer()->getOnlinePlayers());
        $maxPlayers = $this->dynamicMOTD->getServer()->getMaxPlayers();
        $version = $this->dynamicMOTD->getServer()->getVersion();

        $currentMotd = $this->motds[$this->currentIndex];

        $updatedMotd = str_replace([
            '{ONLINE_PLAYERS}',
            '{MAX_PLAYERS}',
            '{VERSION}'
        ], [
            $onlinePlayers,
            $maxPlayers,
            $version,
        ],
            $currentMotd
        );

        $this->dynamicMOTD->getServer()->getNetwork()->setName(
            $updatedMotd
        );

        $this->currentIndex = ($this->currentIndex + 1) % count($this->motds);
    }
}
