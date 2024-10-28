<?php

namespace Zerotoprod\DataModelBuilder\Config;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelBuilder\Helpers\DataModel;

class Config
{
    use DataModel;

    /** The directory DataModels will be saved to. */
    public const  directory = 'directory';

    /** The Fully Qualified Namespace for the DataModels */
    public const  namespace = 'namespace';

    /** The directory DataModels will be saved to. */
    #[Describe(['default' => '.'])]
    public string $directory;

    /** The Fully Qualified Namespace for the DataModels */
    #[Describe(['required' => true])]
    public string $namespace;
}