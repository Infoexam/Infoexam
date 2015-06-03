<?php namespace App\Infoexam\Core;

use Illuminate\Database\Eloquent\Model;

abstract class Entity extends Model
{
    /**
     * Indicates whether the model contains ssn column.
     *
     * @var bool
     */
    protected $ssn = false;

    /**
     * Indicates whether show the flash message.
     *
     * @var bool
     */
    protected $showRemind = true;

    public static function boot()
    {
        parent::boot();

        parent::creating(function($model)
        {
            /*
             * If the model contains ssn column, then generate the ssn.
             */
            if (true === $model->ssn)
            {
                if (false === ($ssn = $model->createSsn()))
                {
                    return false;
                }

                $model->attributes['ssn'] = $ssn;
            }

            $model->stringFinalParsing($model->attributes);
        });

        parent::created(function($model)
        {
            if (true === $model->showRemind)
            {
                flash()->success(trans('general.create.success'));
            }
        });

        parent::updating(function($model)
        {
            $model->stringFinalParsing($model->attributes);
        });

        parent::updated(function($model)
        {
            if (true === $model->showRemind)
            {
                flash()->success(trans('general.update.success'));
            }
        });

        parent::deleted(function($model)
        {
            if (true === $model->showRemind)
            {
                flash()->success(trans('general.delete.success'));
            }
        });
    }

    /**
     * Create ssn key.
     *
     * @return string|false
     */
    public function createSsn()
    {
        if (null === ($length = $this->getColumnLength($this->getTable(), 'ssn')) || 0 === $length)
        {
            return false;
        }

        $attempts = 101;

        while (--$attempts)
        {
            $ssn = str_random($length);

            if (null === ($this->where('ssn', '=', $ssn)->first(['ssn'])))
            {
                return $ssn;
            }
        }

        flash()->error(trans('error.ssn_attempts_failed'));

        return false;
    }

    /**
     * Set $showRemind.
     *
     * @param bool $value
     * @return void
     */
    public function setshowRemind($value = true)
    {
        $this->showRemind = (bool) $value;
    }

    /**
     * Get the column length.
     *
     * @param string $table
     * @param string $column
     * @return integer|null
     */
    public function getColumnLength($table = null, $column = null)
    {
        if (null === $table || null === $column)
        {
            return null;
        }

        return $this->getConnection()->getDoctrineColumn($table, $column)->getLength();
    }

    /**
     * Dealing with the string
     *
     * @param array $attributes
     * @return void
     */
    public function stringFinalParsing(array &$attributes)
    {
        if (is_array($attributes) && count($attributes))
        {
            $while_list = ['image', 'image_s'];

            foreach ($attributes as $key => &$attribute)
            {
                if (is_string($attribute) && ! in_array($key, $while_list) && ! is_serialized($attribute, true))
                {
                    /*
                     * 跳脫 ASCII 小於 32 的字元並補上相對應t長度的隨機字串
                     */
                    $len_original = mb_strlen($attribute);

                    if ($len_original > 0)
                    {
                        /* a lot of bugs */
//                        $attribute = filter_var($attribute, FILTER_SANITIZE_STRING, (FILTER_FLAG_STRIP_LOW | FILTER_FLAG_NO_ENCODE_QUOTES));
//
//                        if ($diff = ($len_original - mb_strlen($attribute)))
//                        {
//                            $attribute .= str_random($diff);
//                        }
                    }
                    /*
                     * 如果字串長度為 0 則更替為 null
                     */
                    else
                    {
                        $attribute = null;
                    }
                }
            }
        }
    }

}