<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Input;

use App\Category;

class Topic extends Content
{
    /**
     * Get Topic models Pager
     *
     * @param int $limit Per page limit
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getTopic($limit = 15)
    {
        return $this->applyFilter()->selectCategory()->topics()->paginate($limit);
    }

    /**
     *
     */
    public function applyFilter()
    {
        if (!Input::has('filter')) return $this;
        switch (Input::get('filter')) {
            case 'recent':
                return $this->recent();
                break;
            case 'excellent':
                return $this->excellent();
                break;
            case 'noreply':
                return $this->noreply();
                break;
            default:
                return $this->orderBy('id');
                break;
        }
    }

    /**
     *
     */
    public function scopeSelectCategory()
    {
        if (Input::has('category')) {
            $categoryId = Category::find(Input::get('category'))->childCategorys->modelKeys();
            return $this->where('category_id', '=', Input::get('category'))->orWhereIn('category_id', $categoryId);
        } else {
            return $this;
        }
    }

    /**
     *
     */
    public function scopeRecent($filter)
    {
        return $this->orderBy('created_at', 'DESC');
    }

    /**
     *
     */
    public function scopeExcellent($filter)
    {
        return $this->where('is_excellent', '=', true)->orderBy('reply_count', 'DESC')->recent();
    }

    /**
     *
     */
    public function scopeNoReply($filter)
    {
        return $this->orderBy('reply_count', 'ASC')->recent();
    }

}
